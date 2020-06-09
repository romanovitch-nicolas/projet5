class Map {
	constructor() {
		this.map = L.map('map');
		this.layer = L.tileLayer('http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			}).addTo(this.map);
		this.navigation = document.querySelectorAll('.map-navigation');

		this.initMap(this.map);
	}

	initMap(map) {
		let markersTable = [];
		ajaxGet('include/listShops.php', function(reponse) {
			let data = JSON.parse(reponse);
			Object.entries(data.shops).forEach(function(shop) {
				let marker = L.marker([shop[1].latitude, shop[1].longitude]).addTo(map).bindPopup('<strong>' + shop[1].name + '</strong><br />' + shop[1].adress + ',<br />' + shop[1].postal_code + ' ' + shop[1].city);
				markersTable.push(marker);
			});
			let group = new L.featureGroup(markersTable);
			map.fitBounds(group.getBounds());
		});

		this.navigation.forEach(function (navigation) {
			navigation.addEventListener("click", function() {
				this.pos = navigation.getAttribute('data-position');
				this.zoom = navigation.getAttribute('data-zoom');
				let pos = this.pos.split(',');
				let zoom = parseInt(this.zoom);
				this.map.setView(pos, zoom);
			}.bind(this));
		}.bind(this));
	}
}

let carte = new Map;