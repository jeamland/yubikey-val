<?php

require_once(dirname(__FILE__) . '/../ykval-config.php');
require_once(dirname(__FILE__) . '/../ykval-db.php');
require_once 'PHPUnit/Framework.php';
 

class DbTest extends PHPUnit_Framework_TestCase
{

  public function setup()
  {
    global $baseParams;
    $this->db=new Db($baseParams['__YKVAL_DB_DSN__'],
		     'root',
		     'lab',
		     $baseParams['__YKVAL_DB_OPTIONS__']);
    $this->db->connect();
    $this->db->customQuery("drop table unittest");
    $this->db->customQuery("create table unittest (id int,value1 int, value2 int)");
  }
  public function test_template()
  {
  }

  public function testConnect()
  {
    $this->assertTrue($this->db->isConnected());
    $this->db->disconnect();
    $this->assertFalse($this->db->isConnected());
  }
  public function testSave()
  {
    $this->assertTrue($this->db->save('unittest', array('value1'=>100,
							 'value2'=>200)));
    $res=$this->db->findByMultiple('unittest', array('value1'=>100,
						      'value2'=>200));
    $this->assertEquals(1, count($res));
  }

  public function testUpdateBy()
  {
    $this->assertTrue($this->db->save('unittest', array('value1'=>100,
							'value2'=>200)));
    $this->db->updateBy('unittest', 'value1', 100, array('value2'=>NULL));
    $res=$this->db->findByMultiple('unittest', array('value1'=>100,
						     'value2'=>NULL));
    $this->assertEquals(1, count($res));
  }
  public function testFindBy()
  {
    $this->assertTrue($this->db->save('unittest', array('value1'=>100,
							'value2'=>200)));
    $res=$this->db->findBy('unittest', 'value1', 100);
    $this->assertEquals(1, count($res));
  }
  public function testUpdate()
  {
    $this->assertTrue($this->db->save('unittest', array('value1'=>100,
							'value2'=>200, 
							'id'=>1)));
    $res=$this->db->findBy('unittest', 'value1', 100);
    $this->assertTrue($this->db->update('unittest', 1, 
					array('value2'=>1000)));
    
    $res=$this->db->findBy('unittest', 'id', 1, 1);
    $this->assertEquals(1000, $res['value2']);
  }
  public function testDeleteByMultiple()
  {
    $this->assertTrue($this->db->save('unittest', array('value1'=>100,
							'value2'=>200, 
							'id'=>1)));
    $this->assertTrue($this->db->deleteByMultiple('unittest', array('value1'=>100, 
								    'value2'=>200)));

  }
}
?>