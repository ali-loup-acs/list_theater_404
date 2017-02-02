<?php

require_once 'include/require.php';

$spec = new Spectacles();

// update Spectacles
$spec->update_spectacles();

render_template('index');
