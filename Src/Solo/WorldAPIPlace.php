<?php
namespace Solo;

/**
 * @file
 * PHP wrapper for the Second Life World API.
 */

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
      'owner' => 'Owner',
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
    try {
      $owner = $this->worldAPI();
      if (isset($owner['ownertype'])) {
        $uuid = $owner['ownerid'];
        switch ($owner['ownertype']) {
          case 'group':
            $result = new WorldAPIGroup($uuid);
            break;
          case 'agent':
            $result = new WorldAPIResident($uuid);
        }
      }
    } catch (WorldAPIException $e) {
      // no-op.
    }
    return $result;
  }

  /**
   * Generates a SLURL URL for this place.
   *
   * Note: only the slurl, not any markup.
   *
   * http://slurl.com/secondlife/region/9/9/9/?img=image&title=title&msg=message
   * @todo: add image, title, and message functionality
   */
  public function slurl($title='', $image='', $message='') {
    $result = '';
    try {
      $data = $this->worldAPI();
      $result = 'http://slurl.com/secondlife/' .
        urlencode($data['region']) . '/' . $data['location'];
    } catch (WorldAPIException $e) {
      $result = '';
    }
    return $result;
  }

}

