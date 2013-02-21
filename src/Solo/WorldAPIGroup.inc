<?php
namespace 'Solo';

/**
 * @file
 * PHP wrapper for the Second Life World API.
 */

require_once('WorldAPI.inc');
require_once('WorldAPIResident.inc');

class WorldAPIGroup extends WorldAPI {
  function resourceType() {
    return 'group';
  }

  function resourceFields() {
    return array(
      'description' => 'Description',
      'member_count' => 'Member Count',
      'open_enrollment' => 'Open Enrollment',
      'membership_fee' => 'Membership Fee',
      'founderid' => 'Founder UUID',
      'founder' => 'Founder',
      'groupid' => 'Group UUID',
      'imageid' => 'Image UUID',
      'mat' => 'Maturity Rating',
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
    try {
      $owner = $this->worldAPI();
      if (isset($owner['founderid'])) {
        $uuid = $owner['founderid'];
        $result = new WorldAPIResident($uuid);
      }
    } catch (WorldAPIException $e) {
      // no-op.
    }
    return $result;
  }

}
