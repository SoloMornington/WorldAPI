<?php
namespace Solo;

/**
 * @file
 * PHP wrapper for the Second Life World API.
 */

class WorldAPIResident extends WorldAPI {
  function resourceType() {
    return 'resident';
  }

  function resourceFields() {
    return array(
      'mat' => 'Maturity Rating',
      'imageid' => 'Image UUID',
      'agentid' => 'Agent UUID',
      'description' => 'Description',
    );
  }

  /**
   * Override worldAPI() to extract name and display name.
   */
  function worldAPI() {
    $data = parent::worldAPI();
    if (isset($data['title'])) {
      // todo: work on this for sure.
      // 'title' can give you results like DiSpLaYnAm3zSuxxor(silly.resident).
      $data['name'] = $data['title'];
      unset($data['title']);
    }
    return $data;
  }

}

