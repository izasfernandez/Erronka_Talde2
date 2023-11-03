window.addEventListener('load', inbentarioa_bistaratu());

/**
 * Inbentarioa bistaratzen duen funtzioa
 */
function inbentarioa_bistaratu() {
    document.getElementById("inbent_taula").innerHTML = "";
    let options = {method: "GET", mode: 'cors'};
    // Ruta local sergio
    // fetch('http://localhost/WES/Erronka%20Proiektua/Erronka/WES/Ekipamendu_controller.php',options)
    // Ruta local Izaskun
    fetch('http://localhost/ERRONKA1/WES/Inbentario_controller.php',options)
    // Ruta local Erik
    // fetch('../WES/Ekipamendu_controller.php',options)
    // Ruta local Imanol
    // fetch('../WES/Ekipamendu_controller.php',options)
    .then(data => {
        return data.json();
    })
    .then(response => {
        inbentario_get(response);
    });
}

function inbentario_get(){

    
}