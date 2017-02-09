// source de données déclarées
var bestPictures = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    // si on veut précharger des trucs avant que la personne recherche, on utilise le prefetch
    //prefetch: '../data/films/post_1960.json',
    remote: {
        url: 'search_zip.php?zip_code=%QUERY',
        wildcard: '%QUERY'
    }
});

function zipcode_template(data) {
    return '<p><a href="list_spectacles.php?zip_code=' + data.zip_code + '">' + data.zip_code + '</a></p>';
}
// a qui appliquer le typeahead et avec quelle source de données
$('#remote .typeahead').typeahead(null, {
    name: 'best-pictures',
    display: 'zip_code',
    source: bestPictures,
    templates: {
        empty: ['<div class="empty-message">',
            'Aucun Spectacle trouvé.',
            '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return zipcode_template(data);
        }
    }
});

$('#remote .typeahead').keypress(function(e) {
    if (e.which == 13) {
        var selectedValue = $('#remote .typeahead')[1].value;
        window.location.href = 'list_spectacles.php?zip_code=' + selectedValue;
    }
});

  $(document).ready(function() {
		$('#smoothScroll').on('click', function() { // Au clic sur un élément
			var page = $(this).attr('href'); // Page cible
			var speed = 750; // Durée de l'animation (en ms)
			$('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
			return false;
		});
	});
