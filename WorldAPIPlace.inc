<?php

require_once('WorldAPI.inc');

class WorldAPIPlace extends WorldAPI {
  function resourceType() {
    return 'place';
  }

  function resourceFields() {
    return array(
      'parcelid', 'description', 'region', 'location', 'snapshot',
      'mat', 'imageid', 'parcel', 'area', 'ownerid', 'ownertype',
      'owner', 'category'
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
}
