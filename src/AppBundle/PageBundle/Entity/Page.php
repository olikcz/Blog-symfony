<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 23.05.2019
 * Time: 13:23
 */

namespace AppBundle\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Page
 * @package Page\Entity
 * @ORM\Entity(repositoryClass="AppBundle\PageBundle\Repository\PageRepository")
 * @ORM\Table(name="page")
 */
class Page
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * Many Pages have one category
     * @ORM\ManyToOne(targetEntity="AppBundle\TermBundle\Entity\Term", inversedBy="pages")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\UserBundle\Entity\User" , inversedBy="pages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Many Groups have Many UserBundle.
     * @ORM\OneToMany(targetEntity="AppBundle\CommentBundle\Entity\Comment", mappedBy="page", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime",  nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->comments = new ArrayCollection();
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
     *
     * @return Page
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
     * Set body
     *
     * @param string $body
     *
     * @return Page
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Page
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set category
     *
     * @param \AppBundle\TermBundle\Entity\Term $category
     *
     * @return Page
     */
    public function setCategory(\AppBundle\TermBundle\Entity\Term $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\TermBundle\Entity\Term
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\CommentBundle\Entity\Comment $comment
     *
     * @return Page
     */
    public function addComment(\AppBundle\CommentBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\CommentBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\CommentBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set user
     *
     * @param \AppBundle\UserBundle\Entity\User $user
     *
     * @return Page
     */
    public function setUser(\AppBundle\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Page
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
