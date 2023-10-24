const webIzena = document.getElementById("title").innerHTML;
const btnFiltroa = document.querySelector("#f-botoi");
const btnGehitu = document.querySelector("#g-botoi");
const btnerabiltzailea = document.querySelector(".header_img2");
const divartikuluak = document.querySelector("#artikuluak");
const divart_markak = document.querySelector(".fmarkak");
const divart_kategoriak = document.querySelector(".kategoriak");
const combobox_art_kategoriak = document.querySelector("#kategoria");
var kategoria = 0;


// Filtro botoia sakatzean filtroko menua ateratzea
if (btnFiltroa != null) {
    btnFiltroa.addEventListener('click', function activatu() {
        document.getElementById('filtroa').classList.toggle('active');
        document.getElementById('filtroa').style.position = "relative";
        if (document.getElementById('gehitu').classList.contains('active')) {
            document.getElementById('gehitu').classList.remove('active');
            document.getElementById('gehitu').style.position = "absolute";
            document.getElementById('f-botoi').classList.toggle('active');
            document.getElementById('g-botoi').classList.toggle('active');
    
        }else{
            document.getElementById('gehitu').classList.remove('active');
            document.getElementById('gehitu').style.position = "absolute";
            document.getElementById('f-botoi').classList.toggle('active');
    
            document.getElementById('menu-mugikorra').classList.toggle('active');
        }
    });
}

// Gehitu botoia sakatzean gehitzeko menua ateratzea
if (btnGehitu != null) {
    btnGehitu.addEventListener('click', function activatu() {
        document.getElementById('gehitu').classList.toggle('active');
        document.getElementById('gehitu').style.position = "relative";
        if (document.getElementById('filtroa').classList.contains('active')) {
            document.getElementById('filtroa').classList.remove('active');
            document.getElementById('filtroa').style.position = "absolute";
            document.getElementById('g-botoi').classList.toggle('active');
            document.getElementById('f-botoi').classList.toggle('active');
    
        }else{
            document.getElementById('filtroa').classList.remove('active');
            document.getElementById('filtroa').style.position = "absolute";
            document.getElementById('g-botoi').classList.toggle('active');
    
            document.getElementById('menu-mugikorra').classList.toggle('active');
        }
    });
}

// Erabiltzaile ikonoa sakatzean, erabiltzailearen menua ateratzea
if (btnerabiltzailea != null) {
    btnerabiltzailea.addEventListener('click', function activatu() {
        document.getElementById('erabil-menu').classList.toggle('active');
    });
}

// LOGIN FUNTZIOAK
/**
 * Pasahitza bistaratzeko eta izkutatzeko funtzioa
 */
function ver_nover() {
    var image = document.getElementById("ver");
    var pass = document.getElementById("pasahitza");
    if (image.src.match('ojo_abierto')) {
        image.src = "img/ojo_cerrado.png";
        pass.type = "text";
    }else {
        image.src = "img/ojo_abierto.png";
        pass.type = "password";
    }
}

/**
 * Login funtzioa da, informazioa hartzen du eta erabiltzailea eta pasahitza komprobatzen du
 */
function login() {
    var erabil = document.getElementById("erabil").value;
    var pass = document.getElementById("pasahitza").value;
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    // Ruta local Izaskun
    // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    // Ruta local Erik
    // fetch('../WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    // Ruta local Imanol
    //fetch('../WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        if (response === "Error") {
            alert("Erabiltzailea ez da existitzen")
        }else{
            if (response["pasahitza"] == pass) {
                window.location.href = "pages/home.html";
            }else{
                alert("Pasahitza okerra")
            }
        }
        
        
    });
}

if (webIzena == "ARTIKULUAK") {
    window.addEventListener('load', artikuluak_bistaratu());
    // window.addEventListener('afterload', artikulu_img_error());
}

if (webIzena == "ARTIKULUAREN INFORMAZIOA") {
    window.addEventListener('load', artikulu_informazioa());
}

// if (webIzena.match("ARTIKULU")) {
//     window.addEventListener('load', artikulu_img_error());
// }

if (divart_markak != null) {
    window.addEventListener('load', markak_kargatu());
}

if (divart_kategoriak != null) {
    window.addEventListener('load', kategoriak_kargatu());
}

function get_id() {
    var paramstr = window.location.search.substr(1);
    var tmparr = paramstr.split("=");
    return (tmparr[1]);
}

function artikulu_img_error(id) {
    const imgs = document.querySelectorAll(id);
    imgs.forEach(element => {
        element.addEventListener("error",function art_error(){
            element.src = "../img/img_art_defecto.png";        
        })
    });
}

/**
 * Artikuluen informazioa itzultzen du
 */
function artikulu_informazioa()
{
    var id_art = get_id();
    let options = {method: "GET", mode: 'cors'};
    var id_kat;
    // ruta sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php?id_art='+id_art,options)
    // Ruta local Izaskun
    // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Ekipamendu_controller.php',options)
    // Ruta local Erik
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Imanol
    // fetch('../WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        document.getElementById("a_izena").value = response["ekipList"][0]["izena"];
        document.getElementById("a_deskribapena").value = response["ekipList"][0]["deskribapena"];
        document.getElementById("a_marka").value = response["ekipList"][0]["marka"];
        document.getElementById("a_modeloa").value = response["ekipList"][0]["modeloa"];
        document.getElementById("a_stock").innerHTML = response["ekipList"][0]["stock"];
        document.getElementById("img_art").src = response["ekipList"][0]["url"];
        document.getElementById("img_url").value = response["ekipList"][0]["url"];
        id_kat = response["ekipList"][0]["idKategoria"];
        fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/kategoria_controller.php?id_kat='+id_kat,options)
        // Ruta local Izaskun
        // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Ekipamendu_controller.php',options)
        // Ruta local Erik
        // fetch('../WES/Ekipamendu_controller.php',options)
        // Ruta local Imanol
        // fetch('../WES/Ekipamendu_controller.php',options)
        .then(data => {
            return data.json();
        })
        .then(response => {
            document.getElementById("a_kategoria").innerHTML = response["katList"][0]["izena"];
        }); 
        artikulu_img_error("#img_art");
    });
    
}

/**
 * Artikuluei formatua ematen dion funtzioa get bidez bidaltzean
 * @param response
 */
function artikulu_formatua_get(response)
{
    for (let i = 0; i < response["artikuluak"]["ekipList"].length; i++) {
        var img = document.createElement("img");
        img.src = response["artikuluak"]["ekipList"][i]["url"];
        img.src = response["artikuluak"]["ekipList"][i]["url"];
        img.alt = response["artikuluak"]["ekipList"][i]["izena"]+" irudia";
        img.classList.add("art_img");
        var izena = document.createElement("h3");
        izena.innerHTML = response["artikuluak"]["ekipList"][i]["izena"];
        var deskribapena  = document.createElement("p");
        deskribapena.innerHTML = response["artikuluak"]["ekipList"][i]["deskribapena"];
        var artikulua  = document.createElement("div");
        var artikulu_esteka = document.createElement("a");
        artikulu_esteka.href = "artikulu_info.html?id="+response["artikuluak"]["ekipList"][i]["id"];
        artikulua.id = response["artikuluak"]["ekipList"][i]["id"];
        artikulua.classList.add("art_info");
        artikulu_esteka.appendChild(img);
        artikulu_esteka.appendChild(izena);
        artikulu_esteka.appendChild(deskribapena);
        artikulua.appendChild(artikulu_esteka);
        divartikuluak.appendChild(artikulua);   
    }
    artikulu_img_error(".art_img")
}

/**
 * Artikuluei formatua ematen dion funtzioa post bidez bidaltzean
 * @param response
 */
function artikulu_formatua_post(response)
{
    for (let i = 0; i < response["ekipList"].length; i++) {
        var img = document.createElement("img");
        img.src = response["ekipList"][i]["url"];
        img.src = response["ekipList"][i]["url"];
        img.alt = response["ekipList"][i]["izena"]+" irudia";
        img.classList.add("art_img");
        var izena = document.createElement("h3");
        izena.innerHTML = response["ekipList"][i]["izena"];
        var deskribapena  = document.createElement("p");
        deskribapena.innerHTML = response["ekipList"][i]["deskribapena"];
        var artikulua  = document.createElement("div");
        var artikulu_esteka = document.createElement("a");
        artikulu_esteka.href = "artikulu_info.html?id="+response["ekipList"][i]["id"];
        artikulua.id = response["ekipList"][i]["id"];
        artikulua.classList.add("art_info");
        artikulu_esteka.appendChild(img);
        artikulu_esteka.appendChild(izena);
        artikulu_esteka.appendChild(deskribapena);
        artikulua.appendChild(artikulu_esteka);
        divartikuluak.appendChild(artikulua);   
    }
    artikulu_img_error(".art_img");
}

/**
 * Artikuluak bistaratzen duen funtzioa
 */
function artikuluak_bistaratu() {
    document.getElementById("artikuluak").innerHTML = "";
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    // Ruta local Izaskun
    // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Ekipamendu_controller.php',options)
    // Ruta local Erik
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Imanol
    // fetch('../WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        artikulu_formatua_get(response);
    });
}

/**
 * Artikuluak filtratzen duen funtzioa
 */
function artikuluak_filtratu() {
    document.getElementById("artikuluak").innerHTML = "";
    var art_izena = document.getElementById("art_izena").value;
    var art_deskribapena = document.getElementById("art_deskribapena").value;
    var art_stck_min = document.getElementById("art_stck_min").value;
    var art_stck_max = document.getElementById("art_stck_max").value;
    var art_markak = markak_filtratu()
    var array_filtroa = {"filtro":true,"art_izena":art_izena,"art_deskribapena":art_deskribapena,"art_stck_min":art_stck_min,"art_stck_max":art_stck_max,"markak":art_markak, "kategoria":kategoria};
    let filtroJson = JSON.stringify(array_filtroa);
    let options = {method: "POST", mode: 'cors', body:filtroJson, header:"Content-Type: application/json; charset=UTF-8"};
    // Sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    // Izaskun
    // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        artikulu_formatua_post(response);
    });
}

/**
 * Markak kargatzen dituen funtzioa
 */
function markak_kargatu()
{
    let options = {method: "GET", mode: 'cors'};
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        response["markak"].forEach(value => {
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.id = value["marka"];
            checkbox.value = value["marka"];
            checkbox.classList.add("marka_checkbox");
            var marka = document.createElement("label");
            marka.innerHTML = value["marka"];
            divart_markak.appendChild(checkbox);
            divart_markak.appendChild(marka);
        });
    });
}

/**
 * Filtratuko diren markak bueltatzen duen funtzioa
 * @returns {array} markak_aukeratuta - aukeratzen dituzun markak
 */
function markak_filtratu() {
    var art_markak = document.querySelectorAll(".marka_checkbox");
    var markak_aukeratuta = [];
    art_markak.forEach(check => {
        if (check.checked == true) {
            markak_aukeratuta[markak_aukeratuta.length] = check.value;
        }
    });
    return(markak_aukeratuta);
}

/**
 *  Kategoria filtroari filtratzeko eventua ematen dion funtzioa da
 */
function kategoria_event() {
    const filtro_kategoria = document.querySelectorAll(".kategoria_filtro");
    if (filtro_kategoria != null) {
        filtro_kategoria.forEach(element => {
            element.addEventListener("click",e =>{
                kategoriaz_filtratu(e.target.getAttribute("id"));
            })
        })
    }
    
}

/**
 * Kategoriak kargatzen duen funtzioa
 */
function kategoriak_kargatu() {
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/kategoria_controller.php',options)
    // Ruta local Izaskun
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Erik
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Imanol
    // fetch('../WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        for (let i = 0; i < response["katList"].length; i++) {
            var text = document.createElement("p");
            text.id = response["katList"][i]["id"];
            text.innerHTML = response["katList"][i]["izena"];
            text.classList.add("kategoria_filtro");
            var option = document.createElement("option");
            option.value = response["katList"][i]["id"];
            option.innerHTML = response["katList"][i]["izena"];
            divart_kategoriak.appendChild(text); 
            if (i != response["katList"].length-1) {
                var hr = document.createElement("hr"); 
                divart_kategoriak.appendChild(hr);  
            }    
            combobox_art_kategoriak.appendChild(option);   
        }
        kategoria_event()
    });
}

/**
 * Filtroak kentzen dituen funtzioa
 */
function filtroa_kendu() {
    const filtro_kategoria = document.querySelectorAll(".kategoria_filtro");
    filtro_kategoria.forEach(element => {
        if (element.classList.contains("active")) {
            kategoria = element.id;
        }
    })
    kategoriaz_filtratu(kategoria);
}

/**
 * Kategoria filtroa kontrolatzen duen funtzioa   
 * @param id
 */
function kategoriaz_filtratu(id) {
    kategoria = id;
    const filtro_kategoria = document.querySelectorAll(".kategoria_filtro");
    filtro_kategoria.forEach(element => {
        element.classList.remove("active");
    })
    document.getElementById(id).classList.toggle("active");
    // Ruta local Izaskun
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Erik
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Imanol
    // fetch('../WES/Ekipamendu_controller.php',options)
    document.getElementById("artikuluak").innerHTML = "";
    var array_filtroa = {"filtro":true,"kategoria":id};
    let filtroJson = JSON.stringify(array_filtroa);
    let options = {method: "POST", mode: 'cors', body:filtroJson, header:"Content-Type: application/json; charset=UTF-8"};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        artikulu_formatua_post(response);
    });
}

/**
 * Artikuluak eguneratzen duen funtzioa da
 */
function artikuluak_eguneratu() {
    var id_art = get_id();
    var art_izena = document.getElementById("a_izena").value;
    var art_desk = document.getElementById("a_deskribapena").value;
    var art_mark = document.getElementById("a_marka").value;
    var art_model = document.getElementById("a_modeloa").value;
    var art_url = document.getElementById("img_url").value;
    var jsonData = {"filtro":false,"id":id_art,"izena":art_izena,"desk":art_desk,"modeloa":art_mark,"marka":art_model, "url":art_url};
    let DataJson = JSON.stringify(jsonData);
    let options = {method: "POST", mode: 'cors', body:DataJson, header:"Content-Type: application/json; charset=UTF-8"};
    // Sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    // Izaskun
    // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Ekipamendu_controller.php',options);
    .then(data => {
        return data.json();
    })
    .then(response => {
        window.location.href = window.location.href;
        if (response.match('Error')) {
            alert("Errorea egon da :".response);
        }else{
            alert("Artikulua eguneratu da")
        }
    });
}

function artikuluak_ezabatu() {
    var id_art = get_id();
    var jsonData = {"id":id_art};
    let DataJson = JSON.stringify(jsonData);
    let options = {method: "DELETE", mode: 'cors', body:DataJson, header:"Content-Type: application/json; charset=UTF-8"};
    // Sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    // Izaskun
    // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Ekipamendu_controller.php',options);
    .then(data => {
        return data.json();
    })
    .then(response => {
        window.location.href = window.location.href;
        if (response.match('Error')) {
            alert("Errorea egon da :".response);
        }else{
            alert("Artikulua ezabatu da")
        }
    });
}
