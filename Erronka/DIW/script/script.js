const webIzena = document.getElementById("title").innerHTML;
const btnFiltroa = document.querySelector("#f-botoi");
const btnGehitu = document.querySelector("#g-botoi");
const btnerabiltzailea = document.querySelector(".header_img2");
const divartikuluak = document.querySelector("#artikuluak");

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
// Pasahitza bistaratzeko eta izkutatzeko funtzioa
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

// Login funtzioa da, erabiltzailearen informazioa hartzen du eta erabiltzailea existitzen bada eta pasahitza zuzena jarri badu komprobatzen du
function login() {
    var erabil = document.getElementById("erabil").value;
    var pass = document.getElementById("pasahitza").value;
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    // Ruta local Izaskun
    // fetch('../WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    // Ruta local Erik
    // fetch('../WES/Erabiltzaile_controller.php?erabil='+erabil,options)
    // Ruta local Imanol
    // fetch('../WES/Erabiltzaile_controller.php?erabil='+erabil,options)
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

function artikuluak_bistaratu() {
    // document.getElementById("artikuluak").innerHTML = "";
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
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
            artikulu_esteka.href = "#";
            artikulua.id = response["ekipList"][i]["id"];
            artikulua.classList.add("art_info");
            artikulu_esteka.appendChild(img);
            artikulu_esteka.appendChild(izena);
            artikulu_esteka.appendChild(deskribapena);
            artikulua.appendChild(artikulu_esteka);
            divartikuluak.appendChild(artikulua);   
        }
    });
}

function artikuluak_filtratu() {
    document.getElementById("artikuluak").innerHTML = "";
    var art_izena = document.getElementById("art_izena").value;
    var art_deskribapena = document.getElementById("art_deskribapena").value;
    var art_stck_min = document.getElementById("art_stck_min").value;
    var art_stck_max = document.getElementById("art_stck_max").value;
    var array_filtroa = {"art_izena":art_izena,"art_deskribapena":art_deskribapena,"art_stck_min":art_stck_min,"art_stck_max":art_stck_max};
    let filtroJson = JSON.stringify(array_filtroa);
    console.log(filtroJson)
    let options = {method: "POST", mode: 'cors', body:filtroJson, header:"Content-Type: application/json; charset=UTF-8"};
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
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
            artikulu_esteka.href = "#";
            artikulua.id = response["ekipList"][i]["id"];
            artikulua.classList.add("art_info");
            artikulu_esteka.appendChild(img);
            artikulu_esteka.appendChild(izena);
            artikulu_esteka.appendChild(deskribapena);
            artikulua.appendChild(artikulu_esteka);
            divartikuluak.appendChild(artikulua);   
        }
    });
}
