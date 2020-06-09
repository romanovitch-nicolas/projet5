<?php
namespace Nicolas\FermeHaffner\Models;

class Shop
{
    protected $id;
    protected $name;
    protected $adress;
    protected $city;
    protected $postalCode;
    protected $latitude;
    protected $longitude;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data) {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if (isset($data['name']))
        {
            $this->setName($data['name']);
        }

        if (isset($data['adress']))
        {
            $this->setAdress($data['adress']);
        }

        if (isset($data['city']))
        {
            $this->setCity($data['city']);
        }

        if (isset($data['postalCode']))
        {
            $this->setPostalCode($data['postalCode']);
        }

        if (isset($data['latitude']))
        {
            $this->setLatitude($data['latitude']);
        }

        if (isset($data['longitude']))
        {
            $this->setLongitude($data['longitude']);
        }
    }

    // Getters    
    public function id() {
        return $this->id;
    }

    public function name() {
        return $this->name;
    }

    public function adress() {
        return $this->adress;
    }

    public function city() {
        return $this->city;
    }

    public function postalCode() {
        return $this->postalCode;
    }

    public function latitude() {
        return $this->latitude;
    }

    public function longitude() {
        return $this->longitude;
    }

    // Setters
    public function setId($id)
    {
        $id = (int)$id;
        if ($id > 0)
        {
            $this->id = $id;
        }
    }

    public function setName($name) {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setAdress($adress) {
        if (is_string($adress))
        {
            $this->adress = $adress;
        }
    }

    public function setCity($city) {
        if (is_string($city))
        {
            $this->city = $city;
        }
    }

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
}