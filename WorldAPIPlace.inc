<?php

/**
 * @file
 * PHP wrapper for the Second Life World API.
 */

require_once('WorldAPI.inc');
require_once('WorldAPIResident.inc');
require_once('WorldAPIGroup.inc');

class WorldAPIPlace extends WorldAPI {
  public function resourceType() {
    return 'place';
  }

  public function resourceFields() {
    return array(
      'parcelid' => 'Parcel UUID',
      'description' => 'Description',
      'region' => 'Region',
      'location' => 'Location',
      'snapshot' => 'Snapshot',
      'mat' => 'Maturity Rating',
      'imageid' => 'Image UUID',
      'parcel' => 'Parcel Name',
      'area' => 'Parcel Area',
      'ownerid' => 'Owner UUID',
      'ownertype' => 'Owner Type',
      'owner' => 'Owner UUID',
      'category' => 'Category',
    );
  }

  /**
   * Override worldAPI().
   *
   * Place data doesn't use the title attribute, so we unset it.
   */
  public function worldAPI() {
    $data = parent::worldAPI();
    unset($data['title']);
    return $data;
  }

  /**
   * Determine the place owner.
   *
   * Could be either a Resident or a Group,
   * or NULL if there was a problem.
   */
  public function owner() {
    $result = NULL;
    $owner = $this->worldAPI();
    if (isset($owner['ownertype'])) {
      $uuid = $owner['ownerid'];
      switch ($owner['ownertype']) {
        case 'group':
          $result = new WorldAPIGroup($uuid);
          break;
        case 'resident':
          $result = new WorldAPIResident($uuid);
      }
    }
    return $result;
  }

}
