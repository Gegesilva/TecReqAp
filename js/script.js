function observação() {
    var texto;
    let d_obs = prompt("Observações:", "");
    if (obs == null || obs == "") {
        texto = "";
    } else {
        texto = d_obs;

        console.log(d_obs);
    }
    var input = document.getElementById("obs");
    input.value = d_obs;

}