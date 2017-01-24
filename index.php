<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

        <div id="the-basics">
          <label for="zip_code">Zip-code</label>
          <input class="typeahead" type="text" class="form-control typeahead" id="zip_code" placeholder="Test">
        </div>

  </body>
</html>

<script type="text/javascript">

var zip_code = ["Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
$(document).ready(function() {
// constructs the suggestion engine
var my_Suggestion_class = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  limit:6,
  local: $.map(zip_code, function(filtered_items) { return { value: filtered_items }; })
});

// kicks off the loading/processing of `local` and `prefetch`
my_Suggestion_class.initialize();

              var typeahead_elem = $('.typeahead');
              typeahead_elem.typeahead({
                  hint: true,
                  highlight: true,
                  minLength: 1
              },
              {
                  name: 'value',
                  displayKey: 'value',
                  source: my_Suggestion_class.ttAdapter(),
                  templates: {
                      empty: [
                          '<div class="noitems">',
                          'Aucun spectacle trouvé !',
                          '</div>'
                      ].join('\n')
                  }
              });
          });

// my_Suggestion_class.initialize();
// var typeahead_elem = $('.typeahead');
// 	typeahead_elem.typeahead({
// 	  hint: true,
// 	  highlight: true,
// 	  minLength: 1
// 	},
// 	{
// 	  // `ttAdapter` wraps the suggestion engine in an adapter that
// 	  // is compatible with the typeahead jQuery plugin
// 		  name: '',
// 		  displayKey: '',
// 		  source: my_Suggestion_class.ttAdapter()
// 	});


</script>
