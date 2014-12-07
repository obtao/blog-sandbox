<?php

namespace Obtao\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\ElasticaBundle\Configuration\Search;
use Obtao\BlogBundle\Entity\Author;
use Obtao\BlogBundle\Entity\Category;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @Search(repositoryClass="Obtao\BlogBundle\Entity\SearchRepository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Obtao\BlogBundle\Entity\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=250, nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $content;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    protected $publishedAt;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Obtao\BlogBundle\Entity\Author")
     */
    protected $authors;

    /**
     * @var \Obtao\BlogBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="\Obtao\BlogBundle\Entity\Category", inversedBy="articles")
     */
    protected $category;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array")
     */
    protected $tags;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->tags = array();
    }

    /**
    * @ORM\PrePersist
    */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function isPublished()
    {
        return (null !== $this->getPublishedAt());
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     * @return Article
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }


    public function addAuthor(Author $author)
    {
        $this->authors->add($author);

        return $this;
    }

    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        if (is_string($tags)) {
            $tags = explode(",", $tags);
        }

        $this->tags = $tags;

        return $this;
    }
}
