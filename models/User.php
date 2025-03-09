<?php
class User {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $date_created;
    private $date_updated;

    public function __construct(
        $id,
        $firstName, 
        $lastName, 
        $email, 
        $password,
        $date_created,
        $date_updated
    ) {
        // Si se proporciona un ID, usalo; de lo contrario, genera uno nuevo
        $this->id = $id ?? uniqid();
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->date_created = $date_created;
        $this->date_updated = $date_updated;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getDateCreated() {
        return $this->date_created;
    }

    public function setDateCreated($date_created) {
        $this->date_created = $date_created;
    }

    public function getDateUpdated() {
        return $this->date_updated;
    }

    public function setDateUpdated($date_updated) {
        $this->date_updated = $date_updated;
    }
}

?>
