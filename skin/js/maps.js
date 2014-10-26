// JavaScript Document
//chamada padrão para inicializar o mapa
// Autor: Jefte Amorim da Costa
var geocoder;
var map;
var marker;
 
function initialize() {
    var latlng = new google.maps.LatLng(-23.6867266, -46.79065109999999);
    var options = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    map = new google.maps.Map(document.getElementById("mapa"), options);
 
    geocoder = new google.maps.Geocoder();
 
    marker = new google.maps.Marker({
        map: map,
		icon: 'skin/images/iconmaps.png'
    });
 
    marker.setPosition(latlng);
}
 
$(document).ready(function () {
    initialize();
});
