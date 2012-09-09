<?php

/**
 * @file PHP wrapper for the Second Life World API.
 */

abstract class WorldAPI {
  var $uuid; // UUID for the resource in question

  var $worldAPIData; // keep the data around and avoid duplicate requests.

  public function __construct($uuid = '') {
    $this->setUUID($uuid);
  }

  public function setUUID($uuid = '') {
    $this->uuid = $uuid;
    return $this->uuid;
  }

  /**
   * Return the resource type.
   */
  protected function resourceType() {
    // Return an empty string in order to generate an error.
    // We do this because subclasses should override this function.
    return '';
  }

  /**
   * Return a list of relevant meta fields.
   *
   * We make this public so that others can grab the list and iterate
   * over it.
   */
  public function resourceFields() {
    // Returns a list of fields we want to glean from the meta tags.
    // We return an empty array because other classes should
    // override this.
    return array();
  }

  /**
   * Build a URL based on type and UUID.
   *
   * We'll get the contents of this URL to parse for World API's
   * meta-data.
   */
  protected function url() {
    $type = $this->resourceType();
    if (empty($type) || empty($this->uuid))
      throw new WorldAPIException('Unable to create resource URL.');
    return 'http://world.secondlife.com/' . $type . '/' . $this->uuid;
  }

  /**
   * Extract data from WorldAPI.
   *
   * Returns key/value pairs for items in the meta fields.
   *
   * Much thanks: http://stackoverflow.com/questions/3711357/
   */
  public function worldAPI() {
    // send back the cache if it's there.
    // todo: make this work.
    if (isset($worldAPIData)) {
      return $worldAPIData;
    }

    $result = array();
    $url = $this->url();
    // If the URL is empty, return an empty record.
    if ($url == '') {
      $result = array_flip($this->resourceFields());
      foreach ($result as $key=>$value) $result[$key] = '';
      return $result;
    }

    // Get the page with cURL.
    // Init with our URL.
    $ch = curl_init($url);
    // Tel cURL we want the results back as a string.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,2);
    // Nab!
    $html = curl_exec($ch);
    curl_close($ch);

    if ($html == '')
      throw new WorldAPIException('Unable to load World API data.');

    //parsing begins here:
    $doc = new DOMDocument();
    // We suppress errors from loadHTML() because Linden Lab
    // is no good at returning well-formed HTML.
    @$doc->loadHTML($html);
    $nodes = $doc->getElementsByTagName('title');

    $title = $nodes->item(0)->nodeValue;

    // We always return title, even though some don't use it.
    $result['title'] = $title;

    $metas = $doc->getElementsByTagName('meta');
    $fields = array_flip($this->resourceFields());
    foreach ($metas as $meta) {
      $key = $meta->getAttribute('name');
      if(array_key_exists($key, $fields))
        $result[$key] = $meta->getAttribute('content');
    }
    $this->worldAPIData = $result;
    $this->worldAPIData['cached'] = 'yes';
    return $result;
  }

  /**
   * Generate an image URL for this resource.
   *
   * Not strictly part of the World API.
   *
   * All World API resources have an imageid, so this function
   * is public.
   *
   * $size is undocumented by Linden Lab, but experimentation reveals:
   * 1 = 256 x 192
   * 2 = 320 x 240
   * 3 = 60 x 45
   *
   * Displayed image will be watermarked by Linden Lab.
   */
  public function imageURL($size = '1') {
    $result = '';
    $data = $this->worldAPI();
    if (isset($data['imageid'])) {
      $uuid = $data['imageid'];
      $result = 'http://secondlife.com/app/image/' . $uuid . '/' . $size;
    }
    return $result;
  }

}

class WorldAPIException extends Exception {
  // Maybe someday there will be something here.
  // For now, just a nice name for our exceptions.
}
