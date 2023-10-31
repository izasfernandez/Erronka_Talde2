// const btnezabatu = document.getElementById('ezabatu');
window.addEventListener("load",erabil());
var usuarioa;

function erabil() {
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Erabiltzaile_controller.php',options)
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
        document.getElementById("e_nan").innerHTML = response["nan"];
        document.getElementById("e_izena").value = response["izena"];
        document.getElementById("e_abizena").value = response["abizena"];
        document.getElementById("e_erabil").value = response["erabiltzailea"];
        document.getElementById("e_rol").innerHTML = response["rola"];
        if (response["rola"] == "A") {
            document.getElementById("ezabatu").hidden = false;
        }else{
            document.getElementById("ezabatu").hidden = true;
        }
        usuarioa = response;
    });
}

// document.getElementById("guardar").addEventListener("click", konprobatu_erroreak());

function izena_konprobatu() {
    if (!document.getElementById("e_izena").value) {
        event.preventDefault();
        document.getElementById("e_izena").setCustomValidity("Izena bete behar da");
    }else{
        document.getElementById("e_izena").setCustomValidity("");
    }
    document.getElementById("e_izena").reportValidity();
}

function abizena_konprobatu() {
    if (!document.getElementById("e_abizena").value) {
        event.preventDefault();
        document.getElementById("e_abizena").setCustomValidity("Abizena bete behar da");
    }else{
        document.getElementById("e_abizena").setCustomValidity("");
    }
    document.getElementById("e_abizena").reportValidity();
}

function erabil_konprobatu() {
    if (!document.getElementById("e_erabil").value) {
        event.preventDefault();
        document.getElementById("e_erabil").setCustomValidity("Erabiltzailea bete behar da");
        document.getElementById("e_erabil").reportValidity();
    }else{
        var erabiltzailea = {"kontsulta":true,"erabil":document.getElementById("e_erabil").value};
        let DataJson = JSON.stringify(erabiltzailea,true);
        let options = {method: "POST", mode: 'cors', body:DataJson, header:"Content-Type: application/json; charset=UTF-8"};
        // Ruta local sergio
        fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Erabiltzaile_controller.php',options)
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
            if (response && usuarioa["erabiltzailea"] != erabiltzailea["erabil"]) {
                document.getElementById("e_erabil").setCustomValidity("Erabiltzailea jadanik existitzen da");
                document.getElementById("e_erabil").reportValidity();
            }else{
                document.getElementById("e_erabil").setCustomValidity("");
                document.getElementById("e_erabil").reportValidity();
            }
        });
    }
}

function pasahitza_zaharra_konprobatu() {
    if (document.getElementById("e_pasa").value == usuarioa["pasahitza"] || !document.getElementById("e_pasa").value) {
        document.getElementById("e_pasa").setCustomValidity("");
    }else{
        event.preventDefault();
        document.getElementById("e_pasa").setCustomValidity("Pasahitza ez dator bat");
    }
    document.getElementById("e_pasa").reportValidity();
}

function pasahitza_berria_konprobatu() {
    if (document.getElementById("e_pasa").value) {
        if (document.getElementById("e_pasa").value == document.getElementById("e_pasa_new").value || !document.getElementById("e_pasa_new").value) {
            event.preventDefault();
            document.getElementById("e_pasa_new").setCustomValidity("Pasahitza berria jarri behar da");
        }else{
            document.getElementById("e_pasa_new").setCustomValidity("");            
        }
    }else{
        if (document.getElementById("e_pasa_new").value) {
            event.preventDefault();
            document.getElementById("e_pasa").setCustomValidity("Pasahitza berria jartzeko pasahitza zaharra jarri behar da");
        }else{
            document.getElementById("e_pasa").setCustomValidity("");            
        }
        document.getElementById("e_pasa").reportValidity();
    }
    document.getElementById("e_pasa_new").reportValidity();
}

function konprobatu_erroreak() {
    const input = document.querySelectorAll(".input");
    var error = false;
    input.forEach(element => {
        if(!element.checkValidity()){
            error = true;
        }
    });
    return error;
}

function gorde() {
    if (!konprobatu_erroreak()) {
        var nan = document.getElementById("e_nan").innerHTML;
        var izena = document.getElementById("e_izena").value;
        var abizena = document.getElementById("e_abizena").value;
        var erabil = document.getElementById("e_erabil").value;
        var pasa = document.getElementById("e_pasa_new").value;
        var jsonData = {"kontsulta":false,"izena":izena,"abizena":abizena,"erabil":erabil,"pasa":pasa, "nan":nan}
        let DataJson = JSON.stringify(jsonData);
        let options = {method: "POST", mode: 'cors', body:DataJson, header:"Content-Type: application/json; charset=UTF-8"};
        // Sergio
        fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Erabiltzaile_controller.php',options)
        // Izaskun
        // fetch('http://localhost/DWES/ERRONKA/Erronka/WES/Erabiltzaile_controller.php',options);
        .then(data => {
            return data.json();
        })
        .then(response => {
            if (response.match('Error')) {
                alert("Errorea egon da :".response);
            }else{
                alert("Erabiltzailea eguneratu da")
            }
            window.location.href = window.location.href;
        });
    }
}
