function refresh_spis() {
    parent.spis.location.reload();
}
function dodaj_element(kontener) {
    var kontener = document.getElementById(kontener);
    //dodanie linii
    //var nowaLinia = document.createElement("br");
    //kontener.appendChild(nowaLinia);
    //dodanie przycisku
    var znacznik = document.createElement('input');
    znacznik.setAttribute('type', 'file');
    znacznik.setAttribute('name', 'new_picture[]');
    znacznik.setAttribute('value', 'plik');
    //znacznik.className = 'upload';
    kontener.appendChild(znacznik);

}

