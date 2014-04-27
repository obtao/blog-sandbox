<?php

namespace Obtao\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Obtao\BlogBundle\Entity\Article;
use FOS\ElasticaBundle\Configuration\Search;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity()
 * @Search(repositoryClass="Obtao\BlogBundle\Entity\SearchRepository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=250, nullable=false)
     */
    protected $label;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Obtao\BlogBundle\Entity\Article", mappedBy="category")
     */
    protected $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->label;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function addArticle(Article $article)
    {
        $this->articles->add($article);

        return $this;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }

    public function getArticles()
    {
        return $this->articles;
    }
}
