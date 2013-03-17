<?php
namespace Mornington\WorldAPI;

class WorldAPITest extends \PHPUnit_Framework_TestCase
{
  public function testWorldAPI() {
  }
  
  public function testGoodURL() {
    $mock = new MockWorldAPI();
    $mock->type = 'test';
    $mock->setUUID('00000000-0000-0000-0000-000000000000');
    $url = $mock->getURL();
  }

  /**
   * @expectedException Mornington\WorldAPI\WorldAPIException
   */
  public function testBadURLType() {
    $mock = new MockWorldAPI();
    $mock->type = NULL;
    $mock->setUUID('00000000-0000-0000-0000-000000000000');
    $url = $mock->getURL();
  }

  /**
   * @expectedException Mornington\WorldAPI\WorldAPIException
   */
  public function testBadURLUUID() {
    $mock = new MockWorldAPI();
    $mock->type = 'test';
    $mock->setUUID('');
    $url = $mock->getURL();
  }

  public function testDataCache() {
    $mock = new MockWorldAPI();
    $mock->type = 'resident';
    $mock->setUUID('6d286553-59ae-409a-887d-ee75df67b834'); // solo mornington. :-)
    $data = $mock->worldAPI();
    $this->assertFalse($mock->didCache == TRUE);
    $data = $mock->worldAPI();
    $this->assertTrue($mock->didCache);
  }

}

