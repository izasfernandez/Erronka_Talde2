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
}

if (webIzena == "ARTIKULUAREN INFORMAZIOA") {
    window.addEventListener('load', artikulu_informazioa());
}

if (divart_markak != null) {
    window.addEventListener('load', markak_kargatu());
}

if (divart_kategoriak != null) {
    window.addEventListener('load', kategoriak_kargatu());
}

/**
 * Artikuluen informazioa itzultzen du
 */
function artikulu_informazioa()
{
    var paramstr = window.location.search.substr(1);
    var tmparr = paramstr.split("=");
    let options = {method: "GET", mode: 'cors'};
    // ruta sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php?id_art='+tmparr[1],options)
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

    }); 
}

/**
 * 
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
}

/**
 * 
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
        // for (let i = 0; i < response["artikuluak"]["ekipList"].length; i++) {
        //     var img = document.createElement("img");
        //     img.src = response["artikuluak"]["ekipList"][i]["url"];
        //     img.src = response["artikuluak"]["ekipList"][i]["url"];
        //     img.alt = response["artikuluak"]["ekipList"][i]["izena"]+" irudia";
        //     img.classList.add("art_img");
        //     var izena = document.createElement("h3");
        //     izena.innerHTML = response["artikuluak"]["ekipList"][i]["izena"];
        //     var deskribapena  = document.createElement("p");
        //     deskribapena.innerHTML = response["artikuluak"]["ekipList"][i]["deskribapena"];
        //     var artikulua  = document.createElement("div");
        //     var artikulu_esteka = document.createElement("a");
        //     artikulu_esteka.href = "#";
        //     artikulua.id = response["artikuluak"]["ekipList"][i]["id"];
        //     artikulua.classList.add("art_info");
        //     artikulu_esteka.appendChild(img);
        //     artikulu_esteka.appendChild(izena);
        //     artikulu_esteka.appendChild(deskribapena);
        //     artikulua.appendChild(artikulu_esteka);
        //     divartikuluak.appendChild(artikulua);   
        // }
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
    console.log(art_markak);
    var array_filtroa = {"art_izena":art_izena,"art_deskribapena":art_deskribapena,"art_stck_min":art_stck_min,"art_stck_max":art_stck_max,"markak":art_markak, "kategoria":kategoria};
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
        // for (let i = 0; i < response["ekipList"].length; i++) {
        //     var img = document.createElement("img");
        //     img.src = response["ekipList"][i]["url"];
        //     img.src = response["ekipList"][i]["url"];
        //     img.alt = response["ekipList"][i]["izena"]+" irudia";
        //     img.classList.add("art_img");
        //     var izena = document.createElement("h3");
        //     izena.innerHTML = response["ekipList"][i]["izena"];
        //     var deskribapena  = document.createElement("p");
        //     deskribapena.innerHTML = response["ekipList"][i]["deskribapena"];
        //     var artikulua  = document.createElement("div");
        //     var artikulu_esteka = document.createElement("a");
        //     artikulu_esteka.href = "#";
        //     artikulua.id = response["ekipList"][i]["id"];
        //     artikulua.classList.add("art_info");
        //     artikulu_esteka.appendChild(img);
        //     artikulu_esteka.appendChild(izena);
        //     artikulu_esteka.appendChild(deskribapena);
        //     artikulua.appendChild(artikulu_esteka);
        //     divartikuluak.appendChild(artikulua);   
        // }
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
 * Markak filtratzen duen funtzioa
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
 *  
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
    var array_filtroa = {"kategoria":id};
    let filtroJson = JSON.stringify(array_filtroa);
    let options = {method: "POST", mode: 'cors', body:filtroJson, header:"Content-Type: application/json; charset=UTF-8"};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        artikulu_formatua_post(response);
        // for (let i = 0; i < response["ekipList"].length; i++) {
        //     var img = document.createElement("img");
        //     img.src = response["ekipList"][i]["url"];
        //     img.src = response["ekipList"][i]["url"];
        //     img.alt = response["ekipList"][i]["izena"]+" irudia";
        //     img.classList.add("art_img");
        //     var izena = document.createElement("h3");
        //     izena.innerHTML = response["ekipList"][i]["izena"];
        //     var deskribapena  = document.createElement("p");
        //     deskribapena.innerHTML = response["ekipList"][i]["deskribapena"];
        //     var artikulua  = document.createElement("div");
        //     var artikulu_esteka = document.createElement("a");
        //     artikulu_esteka.href = "#";
        //     artikulua.id = response["ekipList"][i]["id"];
        //     artikulua.classList.add("art_info");
        //     artikulu_esteka.appendChild(img);
        //     artikulu_esteka.appendChild(izena);
        //     artikulu_esteka.appendChild(deskribapena);
        //     artikulua.appendChild(artikulu_esteka);
        //     divartikuluak.appendChild(artikulua);   
        // }
    });
}
