<html><body>

<?php

require_once('WorldAPIPlace.inc');
require_once('WorldAPIResident.inc');
require_once('WorldAPIGroup.inc');

$resident = new WorldAPIResident('24e6998d-7bf2-4d03-b38b-acf8f2a21fc1');
$place = new WorldAPIPlace('49ef8b3d-a0cd-8f6f-b226-b19c566d9b60');
$wapi = new WorldAPIGroup('e0ed0f49-0de4-37c5-e7be-5f1b60de9bcf');

echo '<h2>Resident</h2>';

$metas = $resident->worldAPI();

foreach ($metas as $key => $data) {
  echo 'place: ' . $key . ' = ' . $data . '<br/><br/>';
}

echo '<h2>Place</h2>';

$metas = $place->worldAPI();

foreach ($metas as $key => $data) {
  echo 'place: ' . $key . ' = ' . $data . '<br/><br/>';
}

echo '<h2>Group</h2>';

$metas = $group->owner();

foreach ($metas as $key => $data) {
  echo 'place: ' . $key . ' = ' . $data . '<br/><br/>';
}

?>
</body></html>
