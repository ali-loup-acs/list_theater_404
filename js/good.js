// source de données déclarées
var bestPictures = new Bloodhound({
datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
queryTokenizer: Bloodhound.tokenizers.whitespace,
// si on veut précharger des trucs avant que la personne recherche, on utilise le prefetch
//prefetch: '../data/films/post_1960.json',
remote: {
  url: 'search_zip.php?search=%QUERY',
  wildcard: '%QUERY'
}
});
function zipcode_template(data){
return '<p><a href="list_spectacles.php?zip_code='+data.zip_code+'">'+data.zip_code+'</a></p>';
}
// a qui appliquer le typeahead et avec quelle source de données
$('#remote .typeahead').typeahead(null, {
name: 'best-pictures',
display: 'zip_code',
source: bestPictures,
templates: {
  /*    header: '<h3 class="search-subtitle"><i class="fa fa-book"></i> Livres</h3>',*/
  /*footer: function(infos) { return moreResults(infos,'books'); },*/
  empty: '<p class="search-no-result">Aucun spectacles trouvés.</p>',
  suggestion: function (data) { return zipcode_template(data) }
}
});

/*$('#remote .typeahead').bind('typeahead:select', function(ev, suggestion) {

console.log(suggestion);

window.location.href = 'list_spectacles.php?zip_code='+suggestion['zip_code'];

});*/

$('#remote .typeahead').keypress(function (e) {
if (e.which == 13) {

  var selectedValue = $('#remote .typeahead')[1].value;
  window.location.href = 'list_spectacles.php?zip_code='+selectedValue;

}
});

function scrollWin() {
    window.scrollBy(0, 100);
}
