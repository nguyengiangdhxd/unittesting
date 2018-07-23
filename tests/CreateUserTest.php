<?php
class CreateUserTest extends TestCase {
	/**
	* Checking postive flow of User Creation Test Cases
	**/
	public function testUerCreationPostiveFlow(){
		$this->post('/createuser', ['name' => 'Ramesh Baskaran', 'mobile_no' => '7299119920'])
             ->seeJson(['status' => 'success']);
	}
	/**
	* Checking negative flow of User Creation Test Cases
	**/
	public function testUerCreationNegativeFlow(){
		$this->post('/createuser', ['name' => '', 'mobile_no' => '7299119920'])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);

        $this->post('/createuser', ['name' => '', 'mobile_no' => ''])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);

        $this->post('/createuser', ['name' => 'Ramesh Baskaran', 'mobile_no' => ''])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);

		$this->post('/createuser', ['name' => 'Ramesh Baskaran', 'mobile_no' => 'adsfsadfasfsa'])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);   

        $this->post('/createuser', ['name' => 'Ramesh Baskaran', 'mobile_no' => '123'])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);

        $this->post('/createuser', ['name' => 'Ramesh Baskaran', 'mobile_no' => '1234567890123456'])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);

        $this->post('/createuser', ['name' => 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz', 'mobile_no' => '1234567890'])
             ->seeJson(['status' => 'error', 'message'=> 'Validation Field']);
	}
}
?>