<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="typeahead.bundle.js"></script>
  <script src="bloodhound.js"></script>
  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <style media="screen">

    .typeahead,
    .tt-query,
    .tt-hint {
      width: 396px;
      height: 30px;
      padding: 8px 12px;
      font-size: 24px;
      line-height: 30px;
      border: 2px solid #ccc;
      -webkit-border-radius: 8px;
      -moz-border-radius: 8px;
      border-radius: 8px;
      outline: none;
    }

    .typeahead {
      background-color: #fff;
    }

    .typeahead:focus {
      border: 2px solid #0097cf;
    }

    .tt-query {
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    }

    .tt-hint {
      color: #999
    }

    .tt-dropdown-menu {
      width: 422px;
      margin-top: 12px;
      padding: 8px 0;
      background-color: #fff;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, 0.2);
      -webkit-border-radius: 8px;
      -moz-border-radius: 8px;
      border-radius: 8px;
      -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
      -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
      box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    .tt-suggestion {
      padding: 3px 20px;
      font-size: 18px;
      line-height: 24px;
    }

    .tt-suggestion.tt-cursor {
      color: #fff;
      background-color: #0097cf;

    }

    .tt-suggestion p {
      margin: 0;
    }
    tt-highlight{
      color:red;
    }
  </style>
</head>
<body>

  <div id="remote">
    <label for="zip_code">Zip-code</label>
    <input class="typeahead" type="text" class="form-control typeahead" id="zip_code" placeholder="Test">
  </div>

  <script>
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
  return '<p><a href=list_spectacles.php?zip_code="'+data.zip_code+'">'+data.zip_code+'</a></p>';
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

</script>
</body>
</html>



