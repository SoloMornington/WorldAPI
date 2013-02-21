<?php
namespace Solo;

/**
 * @file
 * PHP wrapper for the Second Life World API.
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
   *
   * @return string
   */
  abstract protected function resourceType();

  /**
   * Return a list of relevant meta fields.
   *
   * We make this public so that others can grab the list and iterate
   * over it.
   *
   * Array elements should be in the form:
   * 'field' => 'Human-readable',
   * 'agentid' => 'Avatar UUID',
   * ....
   */
  abstract public function resourceFields();

  /**
   * Build a URL based on type and UUID.
   *
   * The URL we need to parse for meta data.
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
    //if (isset($worldAPIData)) {
    //  return $worldAPIData;
    //}

    $result = array();
    try {
      $url = $this->url();
    } catch (WorldAPIException $e) {
      // If we have a bad URL, return an empty record.
      $result = $this->resourceFields();
      foreach ($result as $key => $value) $result[$key] = '';
      return $result;
    }

    // Get the page with cURL.
    // Init with our URL.
    $ch = curl_init($url);
    // Tel cURL we want the results back as a string.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    // Nab!
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (($html == '') || ($httpCode != 200))
      throw new WorldAPIException('Unable to load World API data.');

    //parsing begins here:
    $doc = new \DOMDocument();
    // We suppress errors from loadHTML() because Linden Lab
    // is no good at returning well-formed HTML.
    @$doc->loadHTML($html);
    $htmlnode = $doc->getElementsByTagName('title');
    if ($htmlnode) {
      $titleNode = $htmlnode->item(0);
      if ($titleNode) {
        // We always return title, even though some don't use it.
        $result['title'] = $titleNode->nodeValue;
      }
    }

    $metas = $doc->getElementsByTagName('meta');
    $fields = $this->resourceFields();
    foreach ($metas as $meta) {
      $key = $meta->getAttribute('name');
      if (array_key_exists($key, $fields))
        $result[$key] = $meta->getAttribute('content');
    }
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
   * $uuid allows you to use this function to generate a URL
   * independent of worldAPI data.
   *
   * Displayed image will be watermarked by Linden Lab.
   */
  public function imageURL($size = '2', $uuid = NULL) {
    $prefix = 'http://secondlife.com/app/image/';
    if (!$uuid) {
      $uuid = '00000000-0000-0000-0000-000000000000';
      try {
        $data = $this->worldAPI();
        if (isset($data['imageid'])) {
          $uuid = $data['imageid'];
        }
      } catch (WorldAPIException $e) {
        // no-op.
      }
    }
    $result = $prefix . $uuid . '/' . $size;
    return $result;
  }

} // End of WorldAPI class

class WorldAPIException extends \Exception {
  // Maybe someday there will be something here.
  // For now, just a nice name for our exceptions.
}

