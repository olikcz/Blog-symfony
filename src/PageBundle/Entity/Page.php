<?php

namespace App\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\TermBundle\Entity\Term;


/**
 * Class Term
 * @package App\TermBundle\Entity
 * @ORM\Entity()
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
     * @ORM\ManyToOne(targetEntity="App\TermBundle\Entity\Term", inversedBy="pages")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id")
     */

    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getCategory(): ?Term
    {
        return $this->category;
    }

    public function setCategory(?Term $category): self
    {
        $this->category = $category;

        return $this;
    }

}