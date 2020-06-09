<?php
namespace Nicolas\FermeHaffner\Models;

class Comment
{
    protected $id;
    protected $postId;
    protected $postTitle;
    protected $author;
    protected $mail;
    protected $comment;
    protected $commentDate;
    protected $report;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data) {
        if (isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if (isset($data['post_id']))
        {
            $this->setPostId($data['post_id']);
        }

        if (isset($data['tableposts_title']))
        {
            $this->setPostTitle($data['tableposts_title']);
        }

        if (isset($data['author']))
        {
            $this->setAuthor($data['author']);
        }

        if (isset($data['mail']))
        {
            $this->setMail($data['mail']);
        }

        if (isset($data['comment']))
        {
            $this->setComment($data['comment']);
        }

        if (isset($data['comment_date_fr']))
        {
            $this->setCommentDate($data['comment_date_fr']);
        }

        if (isset($data['report']))
        {
            $this->setReport($data['report']);
        }
    }

    // Getters    
    public function id() {
        return $this->id;
    }

    public function postId() {
        return $this->postId;
    }

    public function postTitle() {
        return $this->postTitle;
    }

    public function author() {
        return $this->author;
    }

    public function mail() {
        return $this->mail;
    }

    public function comment() {
        return $this->comment;
    }

    public function commentDate() {
        return $this->commentDate;
    }

    public function report() {
        return $this->report;
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

    public function setPostId($postId)
    {
        $postId = (int)$postId;
        if ($postId > 0)
        {
            $this->postId = $postId;
        }
    }

    public function setPostTitle($postTitle) {
        if (is_string($postTitle))
        {
            $this->postTitle = $postTitle;
        }
    }

    public function setAuthor($author) {
        if (is_string($author))
        {
            $this->author = $author;
        }
    }

    public function setMail($mail) {
        if (is_string($mail))
        {
            $this->mail = $mail;
        }
    }

    public function setComment($comment) {
        if (is_string($comment))
        {
            $this->comment = $comment;
        }
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }

    public function setReport($report) {
        if ($report == 0 || $report == 1)
        {
            $this->report = $report;
        }
    }
}