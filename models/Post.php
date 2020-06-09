<?php
namespace Nicolas\FermeHaffner\Models;

class Post
{
    protected $id;
    protected $title;
    protected $content;
    protected $imageName;
    protected $creationDate;
    protected $online;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data) {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if (isset($data['title']))
        {
            $this->setTitle($data['title']);
        }

        if (isset($data['content']))
        {
            $this->setContent($data['content']);
        }

        if (isset($data['image_name']))
        {
            $this->setImageName($data['image_name']);
        }

        if (isset($data['creation_date_fr']))
        {
            $this->setCreationDate($data['creation_date_fr']);
        }

        if (isset($data['online']))
        {
            $this->setOnline($data['online']);
        }
    }

    // Getters    
    public function id() {
        return $this->id;
    }

    public function title() {
        return $this->title;
    }

    public function content() {
        return $this->content;
    }

    public function imageName() {
        return $this->imageName;
    }

    public function creationDate() {
        return $this->creationDate;
    }

    public function online() {
        return $this->online;
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

    public function setTitle($title) {
        if (is_string($title))
        {
            $this->title = $title;
        }
    }

    public function setContent($content) {
        if (is_string($content))
        {
            $this->content = $content;
        }
    }

    public function setImageName($imageName) {
        if (is_string($imageName))
        {
            $this->imageName = $imageName;
        }
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setOnline($online) {
        if ($online == 0 || $online == 1)
        {
            $this->online = $online;
        }
    }
}