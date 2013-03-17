<?php
namespace Mornington\WorldAPI;

class MockWorldAPI extends WorldAPI {

  public $type;
  
  public $didCache;

  protected function resourceType() {
    return $this->type;
  }

  function resourceFields() {
    return array();
  }
  
  public function getURL() {
    return $this->url();
  }
  
  protected function getData() {
    $this->didCache = TRUE;
    return parent::getData();
  }

}
