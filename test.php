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

  $(document).ready(function() {

    var list_spectacles = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '../', //url where sql request is
      remote: {
        url: '../', // url of the page containing user request
        wildcard: '%QUERY'
      }
    });

    $('#remote .typeahead').typeahead(null, {
      name: 'list_spectacles',
      display: 'value',
      source: list_spectacles
    });

  });





</script>
