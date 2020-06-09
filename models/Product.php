<?php
namespace Nicolas\FermeHaffner\Models;

class Product
{
    protected $id;
    protected $category_id;
    protected $categoryName;
    protected $name;
    protected $description;
    protected $imageName;
    protected $creationDate;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data) {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if (isset($data['category_id']))
        {
            $this->setCategoryId($data['category_id']);
        }

        if (isset($data['tablecategories_name']))
        {
            $this->setCategoryName($data['tablecategories_name']);
        }

        if (isset($data['name']))
        {
            $this->setName($data['name']);
        }

        if (isset($data['description']))
        {
            $this->setDescription($data['description']);
        }

        if (isset($data['image_name']))
        {
            $this->setImageName($data['image_name']);
        }

        if (isset($data['creation_date_fr']))
        {
            $this->setCreationDate($data['creation_date_fr']);
        }
    }

    // Getters    
    public function id() {
        return $this->id;
    }

    public function categoryId() {
        return $this->categoryId;
    }

    public function categoryName() {
        return $this->categoryName;
    }

    public function name() {
        return $this->name;
    }

    public function description() {
        return $this->description;
    }

    public function imageName() {
        return $this->imageName;
    }

    public function creationDate() {
        return $this->creationDate;
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

    public function setCategoryId($categoryId)
    {
        $categoryId = (int)$categoryId;
        if ($categoryId > 0)
        {
            $this->categoryId = $categoryId;
        }
    }

    public function setCategoryName($categoryName) {
        if (is_string($categoryName))
        {
            $this->categoryName = $categoryName;
        }
    }

    public function setName($name) {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setDescription($description) {
        if (is_string($description))
        {
            $this->description = $description;
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
}