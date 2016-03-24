<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 20.03.2016
 * Time: 16:06
 */
class NewsArticle
{
    const MYSQL_DATE_TIME_FORMAT = "Y-m-d H:i:s";
    /**
     * @var int id of the NewsArticle
     */
    private $id;
    /**
     * @var string  title of the NewsArticle
     */
    private $title;

    /**
     * @var DateTime date
     */
    private $date;

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $owner User|null
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
    /**
     * @var string  content of the NewsArticle
     */
    private $content;

    /**
     * @var User owner of the NewsArticle
     */
    private $owner;
    /**
     * @return string title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string  $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string  $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param Date|string|null $date
     */
    public function setDate($date)
    {
        if (null == $date || $date instanceof DateTime) {
            $this->$date = $date;
        } else { // convert db date to DateTime
            $this->date = DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $date);
        }
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    public function __construct($title, $content, $owner = null, $id = null)
    {
        $this->title=$title;
        $this->content=$content;
        $this->owner=$owner;
        $this->id=$id;
    }


}