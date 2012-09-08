<html><body>

<?php

require_once('WorldAPIPlace.inc');
require_once('WorldAPIResident.inc');
require_once('WorldAPIGroup.inc');

$resident = new WorldAPIResident('6d286553-59ae-409a-887d-ee75df67b834');
$place = new WorldAPIPlace('59760961-da48-f915-df85-9eff42226ba3');
$group = new WorldAPIGroup('07e23275-7192-e30d-eec1-27c181e1910d');

echo '<h2>Resident</h2>';

$metas = $resident->worldAPI();

echo '<img src="' . $resident->imageURL() . '"></br>';

foreach ($metas as $key => $data) {
  echo 'resident: ' . $key . ' = ' . $data . '<br/><br/>';
}

echo '<h2>Place</h2>';

$metas = $place->worldAPI();

echo '<img src="' . $place->imageURL() . '"></br>';

foreach ($metas as $key => $data) {
  echo 'place: ' . $key . ' = ' . $data . '<br/><br/>';
}

echo '<h2>Owner</h2>';

$owner = $place->owner();

$metas = $owner->worldAPI();

echo '<img src="' . $owner->imageURL() . '"></br>';

foreach ($metas as $key => $data) {
  echo 'owner: ' . $key . ' = ' . $data . '<br/><br/>';
}


/*
echo '<h2>Group</h2>';

$metas = $group->worldAPI();

foreach ($metas as $key => $data) {
  echo 'group: ' . $key . ' = ' . $data . '<br/><br/>';
}*/

?>
</body></html>
