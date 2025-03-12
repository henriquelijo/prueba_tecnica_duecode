<?php

class Player {
    private $id;
    private $name;
    private $team_id;
    private $number;
    private $description;
    private $date_created;
    private $date_updated;
    private $captain;

    public function __construct(
        $id, 
        $name, 
        $team_id, 
        $number, 
        $description, 
        $date_created, 
        $date_updated,
        $captain
        ) {
        $this->id = $id;
        $this->name = $name;
        $this->team_id = $team_id;
        $this->number = $number;
        $this->description = $description;
        $this->date_created = $date_created;
        $this->date_updated = $date_updated;
        $this->captain = $captain;
    }

    // Getters y setters...
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getTeamId() { return $this->team_id; }
    public function setTeamId($team_id) { $this->team_id = $team_id; }

    public function getNumber() { return $this->number; }
    public function setNumber($number) { $this->number = $number; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    public function getDateCreated() { return $this->date_created; }
    public function setDateCreated($date_created) { $this->date_created = $date_created; }

    public function getDateUpdated() { return $this->date_updated; }
    public function setDateUpdated($date_updated) { $this->date_updated = $date_updated; }

    public function getCaptain() { return $this->captain; }
    public function setCaptain($captain) { $this->captain = $captain; }
}
?>