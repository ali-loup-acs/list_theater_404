/*
Plugin Name: France regions map
Plugin URI: http://blog.comersis.com/articles/SVG-Raphael-map/
Description: France departements map.
Version: fr-reg-1.0215
Author: S.Marmion ©2015
Author URI: http://www.cmap.comersis.com
License: non-comercial
*/
		var mapfill = "#99CC66";		// Couleur de remplissage des régions
		var maphover_fill = "#22aa22";	// Couleur de survol au passage de la souris
		var mapstroke = "#FFFFFF";		// Couleur des lignes de séparation des régions
		var mapstroke_width = 1.2;		// Epaisseur des lignes de séparation des régions (en points)
		var mapWidth=300;				// Largeur de la carte en pixels
		var mapHeight=300;				// Hauteur de la carte en pixels (facultatif)
		

/*
Modifiez ci-dessous les 2 variables pour chaque région :
	
	title:	" Texte associé à la région ";
	
	url:	" Lien vers la page ou le site souhaité ";

*/		
var paths = {
Z1: {
title: "Alsace-Champagne-Ardenne-Lorraine",
url: "http://google.fr"
},
Z2: {
title: "Aquitaine-Limousin-Poitou-Charentes",
url: "#"
},
Z3: {
title: "Auvergne-Rhône-Alpes",
url: "#"
},
Z4: {
title: "Bourgogne-Franche-Comté",
url: "#"
},
Z5: {
title: "Bretagne",
url: "#"
},
Z6: {
title: "Centre",
url: "#"
},
Z7: {
title: "Corse",
url: "#"
},
Z8: {
title: "Languedoc-Roussillon-Midi-Pyrénées",
url: "#"
},
Z9: {
title: "Ile-de-France",
url: "#"
},
Z10: {
title: "Nord-Pas-de-Calais-Picardie",
url: "#"
},
Z11: {
title: "Normandie",
url: "#"
},
Z12: {
title: "Pays-de-la-Loire",
url: "#"
},
Z13: {
title: "Provence-Alpes-Côte-d-Azur",
url: "#"
}
}