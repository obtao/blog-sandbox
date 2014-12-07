<?php

namespace Obtao\BlogBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class ArticleSearch
{
    public static $sortChoices = array(
        'publishedAt desc' => 'Publication date : new to old',
        'publishedAt asc' => 'Publication date : old to new',
    );

    // begin of publication range
    protected $dateFrom;

    // end of publication range
    protected $dateTo;

    // published or not
    protected $published;

    protected $title;

    // define the field use for the sorting
    protected $sort = 'publishedAt';

    // define the sort order
    protected $direction = 'desc';

    // a "virtual" property to add a select tag
    protected $sortSelect;

    // the page number
    protected $page = 1;

    // the number of items per page
    protected $perPage = 10;

    public function __construct()
    {
        // initialise the dateFrom to "two year ago", and the dateTo to "today"
        $date = new \DateTime();
        $years = new \DateInterval('P2Y');
        $date->sub($years);
        $date->setTime('00', '00', '00');

        $this->dateFrom = $date;
        $this->dateTo = new \DateTime();
        $this->dateTo->setTime('23', '59', '59');

        $this->initSortSelect();
    }

    public function setDateFrom(\DateTime $dateFrom)
    {
        if ($dateFrom != "") {
            $dateFrom->setTime('00', '00', '00');
            $this->dateFrom = $dateFrom;
        }

        return $this;
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateTo(\DateTime $dateTo)
    {
        if ($dateTo != "") {
            $dateTo->setTime('23', '59', '59');
            $this->dateTo = $dateTo;
        }

        return $this;
    }

    public function clearDates()
    {
        $this->dateTo = null;
        $this->dateFrom = null;
    }

    public function getDateTo()
    {
        return $this->dateTo;
    }

    public function isPublished()
    {
        return $this->published;
    }

    public function setPublished($published)
    {
        $this->published = $published;

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

    public function handleRequest(Request $request)
    {
        $this->setPage($request->get('page', 1));
        $this->setSort($request->get('sort', 'publishedAt'));
        $this->setDirection($request->get('direction', 'desc'));
    }

    public function getPage()
    {
        return $this->page;
    }


    public function setPage($page)
    {
        if ($page !== null) {
            $this->page = $page;
        }

        return $this;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function setPerPage($perPage = null)
    {
        if ($perPage !== null) {
            $this->perPage = $perPage;
        }

        return $this;
    }

    public function setSortSelect($sortSelect)
    {
        if ($sortSelect !== null) {
            $this->sortSelect =  $sortSelect;
        }
    }

    public function getSortSelect()
    {
        return $this->sort.' '.$this->direction;
    }

    public function initSortSelect()
    {
        $this->sortSelect = $this->sort.' '.$this->direction;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        if ($sort !== null) {
            $this->sort = $sort;
            $this->initSortSelect();
        }

        return $this;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($direction)
    {
        if ($direction !== null) {
            $this->direction = $direction;
            $this->initSortSelect();
        }

        return $this;
    }
}
