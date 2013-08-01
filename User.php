<?php
class User{
	private $firstName;
	private $lastName;
	private $email;
	private $table='users';
	public function __construct(){
	}
	// set first name
	public function setFirstName($firstName){
		$this->firstName=$firstName;
	}
	// set last name
	public function setLastName($lastName){
		$this->lastName=$lastName;
	}
	// set email
	public function setEmail($email){
		$this->email=$email;
	}
	// fetch row
	public function fetch($id){
		if(!$row=mysql_query("SELECT * FROM $this->table WHERE id='$id'")){
			throw new Exception('Error fetching row');
		}
		return $row;
	}
	// insert row
	public function insert(){
		if(!mysql_query("INSERT INTO $this->table (firstname,lastname,email) VALUES ($this->firstName,$this->lastName,$this->email)")){
			throw new Exception('Error inserting row');
		}
	}
	// update row
	public function update($id){
		if(!mysql_query("UPDATE $this->table SET firstname='$this->firstName,lastname=$this->lastName,email=$this->email WHERE id='$id'")){
			throw new Exception('Error updating row');
		}
	}
	// delete row
	public function delete($id){
		if(!mysql_query("DELETE FROM $this->table WHERE id='$id'")){
			throw new Exception('Error deleting row');
		}
	}
}




try{
	$user=new User();
	// set first name
	$user->setFirstName('John ');
	// set last name
	$user->setlastName('Smith');
	// set email
	$user->setEmail('smith@domain.com');
	// insert row
	$user->insert();

	// set first name
	$user->setFirstName('Johnny');
	// set last name
	$user->lastName('Smith');
	// set email
	$user->setEmail('johnny@domain.com');
	// update row
	$user->update(1);
	// delete row
	$user->delete(1);
}
catch(Exception $e){
	echo $e->getMessage();
	exit();
}
