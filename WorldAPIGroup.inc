<?php

require_once('WorldAPI.inc');
require_once('WorldAPIResident.inc');

class WorldAPIGroup extends WorldAPI {
  function resourceType() {
    return 'group';
  }

  function resourceFields() {
    return array(
      'description',
      'member_count',
      'open_enrollment',
      'membership_fee',
      'founderid',
      'founder',
      'groupid',
      'imageid',
      'mat'
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
   * Determine the group founder.
   *
   * Will be a WorldAPIResident object,
   * or NULL if there was a problem.
   */
  public function founder() {
    $result = NULL;
    $owner = $this->worldAPI();
    if (isset($owner['founderid'])) {
      $uuid = $owner['founderid'];
      $result = new WorldAPIResident($uuid);
    }
    return $result;
  }

}
