let map = L.map('map', {
    zoomControl: false
}).setView([48.86055605437785, 2.3446300176453168], 13);

// Ajout manuel du contrôle de zoom en bas à droite
L.control.zoom({
    position: 'bottomright'
}).addTo(map);

// stadiamaps stamenterrain
let mapLayer = L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_terrain/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 4,
	maxZoom: 17,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://www.stamen.com/" target="_blank">Stamen Design</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'
});

// Récupération de l'élément contenant les informations des cinémas
const cinemaInfoDiv = document.querySelector('.section-cinema');
let mapInteractionEnabled = true; // Suivi de l'état de la carte
// Quand la souris entre dans la div des cinémas
cinemaInfoDiv.addEventListener('mouseenter', () => {
    map.dragging.disable(); // Désactive le déplacement de la carte
    map.scrollWheelZoom.disable(); // Désactive le zoom à la molette
    map.doubleClickZoom.disable(); // Désactive le zoom au double-clic
});

// Quand la souris quitte la div des cinémas
cinemaInfoDiv.addEventListener('mouseleave', () => {
    map.dragging.enable(); // Réactive le déplacement
    map.scrollWheelZoom.enable(); // Réactive le zoom à la molette
    map.doubleClickZoom.enable(); // Réactive le zoom au double-clic
});
// Gestionnaire pour basculer l'état de la carte au clic
cinemaInfoDiv.addEventListener('click', () => {
    if (mapInteractionEnabled) {
        map.dragging.disable(); // Désactive le déplacement
        map.scrollWheelZoom.disable(); // Désactive le zoom à la molette
        map.doubleClickZoom.disable(); // Désactive le zoom au double-clic
        mapInteractionEnabled = false;
    } else {
        map.dragging.enable(); // Réactive le déplacement
        map.scrollWheelZoom.enable(); // Réactive le zoom à la molette
        map.doubleClickZoom.enable(); // Réactive le zoom au double-clic
        mapInteractionEnabled = true;
    }
});

mapLayer.addTo(map);
let cinemas = document.querySelectorAll('.cinema');

let markers = [];

cinemas.forEach(function(cinema) {
    // récupérer les data des voyages via les attributs
	let id = parseFloat(cinema.getAttribute('data-id'))
    let latitude = parseFloat(cinema.getAttribute('data-lat'));
    let longitude = parseFloat(cinema.getAttribute('data-long'));

	// création du marker
    let redIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        iconSize: [25, 41], // Taille du marqueur
        iconAnchor: [12, 41], // Point d'ancrage du marqueur
        shadowSize: [41, 41], // Taille de l'ombre
        shadowAnchor: [12, 41] // Point d'ancrage de l'ombre
    });

    let hoverIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-black.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        shadowSize: [41, 41],
        shadowAnchor: [12, 41]
    });

    // ajoute de "customIcon" sur la carte
    let marker = L.marker([longitude, latitude], { icon: redIcon }).addTo(map);
    markers[id] = marker;

    // Survol de la div
    cinema.addEventListener("mouseenter", function () {
        setTimeout(() => marker.setIcon(hoverIcon), 0); // Essayer de forcer la mise à jour
    });

    // Sortie de la div
    cinema.addEventListener("mouseleave", function () {
        setTimeout(() => marker.setIcon(redIcon), 0); // Essayer de forcer la mise à jour
    });
});
