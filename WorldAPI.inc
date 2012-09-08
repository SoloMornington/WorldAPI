<?php

abstract class WorldAPI {
  var $uuid; // UUID for the resource in question
  
  var $worldAPIData; // keep the data around and avoid duplicate requests.
  
  function __construct($uuid = '') {
    $this->setUUID($uuid);
  }
  
  function setUUID($uuid = '') {
    $this->uuid = $uuid;
    return $this->uuid;
  }

  /**
   * Build a URL based on type and UUID.
   */
  protected function url() {
    $type = $this->resourceType();
    if (empty($type) || empty($this->uuid)) return '';
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
    if (!empty($worldAPIData)) {
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
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  
    $html = curl_exec($ch);
    curl_close($ch);
    
    //parsing begins here:
    $doc = new DOMDocument();
    $doc->loadHTML($html);
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
  
  protected function resourceType() {
    // override this, please.
    return '';
  }

  protected function resourceFields() {
    // Returns a list of fields we want to glean from the meta tags.
    // We return an empty array because other classes should
    // override this.
    return array();
  }
}