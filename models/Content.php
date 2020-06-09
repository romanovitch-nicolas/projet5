<?php
namespace Nicolas\FermeHaffner\Models;

class Content
{
    protected $id;
    protected $flag;
    protected $banner;
    protected $imageOne;
    protected $imageTwo;
    protected $textOne;
    protected $textTwo;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data) {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if (isset($data['flag']))
        {
            $this->setFlag($data['flag']);
        }

        if (isset($data['banner']))
        {
            $this->setBanner($data['banner']);
        }

        if (isset($data['image_1']))
        {
            $this->setImageOne($data['image_1']);
        }

        if (isset($data['image_2']))
        {
            $this->setImageTwo($data['image_2']);
        }

        if (isset($data['text_1']))
        {
            $this->setTextOne($data['text_1']);
        }

        if (isset($data['text_2']))
        {
            $this->setTextTwo($data['text_2']);
        }
    }

    // Getters    
    public function id() {
        return $this->id;
    }

    public function flag() {
        return $this->flag;
    }

    public function banner() {
        return $this->banner;
    }

    public function imageOne() {
        return $this->imageOne;
    }

    public function imageTwo() {
        return $this->imageTwo;
    }

    public function textOne() {
        return $this->textOne;
    }

    public function textTwo() {
        return $this->textTwo;
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

    public function setFlag($flag) {
        if (is_string($flag))
        {
            $this->flag = $flag;
        }
    }

    public function setBanner($banner) {
        if (is_string($banner))
        {
            $this->banner = $banner;
        }
    }

    public function setImageOne($imageOne) {
        if (is_string($imageOne))
        {
            $this->imageOne = $imageOne;
        }
    }

    public function setImageTwo($imageTwo) {
        if (is_string($imageTwo))
        {
            $this->imageTwo = $imageTwo;
        }
    }

    public function setTextOne($textOne) {
        if (is_string($textOne))
        {
            $this->textOne = $textOne;
        }
    }

    public function setTextTwo($textTwo) {
        if (is_string($textTwo))
        {
            $this->textTwo = $textTwo;
        }
    }
}