<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 25.05.2019
 * Time: 10:01
 */

namespace AppBundle\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @package CommentBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\CommentBundle\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 */

class Comment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public static $lastInsertedId = 50;

    /**
     * @ORM\Column(type="text")
     */

    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\PageBundle\Entity\Page", inversedBy="comments")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\UserBundle\Entity\User", inversedBy="comments", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $parent_comment_id;

    /**
     * @var
     * @ORM\Column(type="boolean")
     */
    private $isDeleted;


    /**
     * @ORM\Column(type="datetime")
     */
    private $created;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();

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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Comment
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
     * Add page
     *
     * @param \AppBundle\PageBundle\Entity\Page $page
     *
     * @return Comment
     */
    public function setPage(\AppBundle\PageBundle\Entity\Page $page)
    {
        $this->page = $page;

        return $this;
    }
    /**
     * Get pages
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set user
     *
     * @param \AppBundle\UserBundle\Entity\User $user
     *
     * @return Comment
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
     * Set parentCommentId
     *
     * @param integer $parentCommentId
     *
     * @return Comment
     */
    public function setParentCommentId($parentCommentId)
    {
        $this->parent_comment_id = $parentCommentId;

        return $this;
    }

    /**
     * Get parentCommentId
     *
     * @return integer
     */
    public function getParentCommentId()
    {
        return $this->parent_comment_id;
    }

    /**
     * Set replies
     *
     * @param boolean $replies
     *
     * @return Comment
     */
    public function setReplies($replies)
    {
        $this->replies = $replies;

        return $this;
    }

    /**
     * Get replies
     *
     * @return boolean
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Comment
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
}
