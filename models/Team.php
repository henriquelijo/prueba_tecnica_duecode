<?php
class Team {
    private $id;
    private $name;
    private $city;
    private $sport;
    private $description;
    private $date_fundation;
    private $date_created;
    private $date_updated;
   
    public function __construct(
        $id,
        $name, 
        $city, 
        $sport, 
        $description, 
        $date_fundation,
        $date_created,
        $date_updated
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->sport = $sport;
        $this->description = $description;
        $this->date_fundation = $date_fundation;
        $this->date_created = $date_created;
        $this->date_updated = $date_updated;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getCity() { return $this->city; }
    public function getSport() { return $this->sport; }
    public function getDescription() { return $this->description; }
    public function getDateFundation() { return $this->date_fundation; }
    public function getDateCreated() { return $this->date_created; }
    public function getDateUpdated() { return $this->date_updated; }

    public function setId($id) { $this->id = $id; }

    public function setName($name) {
        if (empty($name)) throw new InvalidArgumentException("El nombre es requerido");
        $this->name = $name;
    }

    public function setCity(string $city) { $this->city = $city; }

    public function setSport(string $sport) {
        if (empty($sport)) throw new InvalidArgumentException("El deporte es requerido");
        $this->sport = $sport;
    }

    public function setDescription(string $description) {
        if (empty($description)) throw new InvalidArgumentException("La descripción es requerida");
        $this->description = $description;
    }

    public function setDateFundation(?string $date) {
        if (!empty($date) && !$this->validateDate($date)) {
            throw new InvalidArgumentException("Formato de fecha inválido (YYYY-MM-DD)");
        }
        $this->date_fundation = $date;
    }

    public function setDateUpdated($date_updated) { $this->date_updated = $date_updated; }

    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
?>