<?php

namespace Obtao\BlogBundle\Model;

class ArticleSearch
{
    // begin of publication range
    protected $dateFrom;

    // end of publication range
    protected $dateTo;

    // published or not
    protected $isPublished;

    protected $title;

    public function __construct()
    {
        // initialise the dateFrom to "one month ago", and the dateTo to "today"
        $date = new \DateTime();
        $month = new \DateInterval('P1Y');
        $date->sub($month);
        $date->setTime('00','00','00');

        $this->dateFrom = $date;
        $this->dateTo = new \DateTime();
        $this->dateTo->setTime('23','59','59');
    }

    public function setDateFrom($dateFrom)
    {
        if($dateFrom != ""){
            $dateFrom->setTime('00','00','00');
            $this->dateFrom = $dateFrom;
        }

        return $this;
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateTo($dateTo)
    {
        if($dateTo != ""){
            $dateTo->setTime('23','59','59');
            $this->dateTo = $dateTo;
        }

        return $this;
    }

    public function clearDates(){
        $this->dateTo = null;
        $this->dateFrom = null;
    }

    public function getDateTo()
    {
        return $this->dateTo;
    }

    public function isPublished()
    {
        return $this->isPublished;
    }

    public function setPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}