<html><body>

<?php

require_once('WorldAPIPlace.inc');
require_once('WorldAPIResident.inc');
require_once('WorldAPIGroup.inc');

$resident = new WorldAPIResident('6d286553-59ae-409a-887d-ee75df67b834');
$place = new WorldAPIPlace('59760961-da48-f915-df85-9eff42226ba3');
$wapi = new WorldAPIGroup('07e23275-7192-e30d-eec1-27c181e1910d');

echo '<h2>Resident</h2>';

$metas = $resident->worldAPI();

foreach ($metas as $key => $data) {
  echo 'resident: ' . $key . ' = ' . $data . '<br/><br/>';
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
