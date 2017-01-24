require_once 'Spectacles.class.php';

// nouvel objet spectacles
$spectacles = new Spectacles();

// préparer les champs
$spectacles->setUpdateFiels(array(
    'title' => 'Mon super titre',
));

// enregistrer !
// si on ajoute true en deuxième paramètre, on peut récupérer l'id du nouvel enregistrement
$new_id = $spectacles->setData(null,true);

// récupérer (SELECT) le nouvel enregistrement
$new_row = $spectacles->getData($new_id);

// afficher le nouvel enregistrement récupéré
print_r($new_row);
