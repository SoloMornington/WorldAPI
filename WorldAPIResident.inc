<?php

require_once('WorldAPI.inc');

class WorldAPIResident extends WorldAPI {
  function resourceType() {
    return 'resident';
  }

  function resourceFields() {
    return array(
      'mat', 'imageid', 'agentid', 'description'
    );
  }

  /**
   * Override worldAPI() to extract name and display name.
   */
  function worldAPI() {
    $data = parent::worldAPI();
    if (isset($data['title'])) {
      // todo: work on this for sure.
      $data['name'] = $data['title'];
      unset($data['title']);
    }
    return $data;
  }

}
