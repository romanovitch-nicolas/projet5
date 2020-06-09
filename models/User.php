<?php
namespace Nicolas\FermeHaffner\Models;

class User
{
    protected $id;
    protected $login;
    protected $pass;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data) {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if (isset($data['login']))
        {
            $this->setLogin($data['login']);
        }

        if (isset($data['pass']))
        {
            $this->setPass($data['pass']);
        }
    }

    // Getters    
    public function id() {
        return $this->id;
    }

    public function login() {
        return $this->login;
    }

    public function pass() {
        return $this->pass;
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

    public function setLogin($login) {
        if (is_string($login))
        {
            $this->login = $login;
        }
    }

    public function setPass($pass) {
        if (is_string($pass))
        {
            $this->pass = $pass;
        }
    }
}