<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $post_title;

    /**
     * @ORM\Column(type="text")
     */
    private $post_content;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $post_status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     */
    private $post_author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostTitle(): ?string
    {
        return $this->post_title;
    }

    public function setPostTitle(string $post_title): self
    {
        $this->post_title = $post_title;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->post_content;
    }

    public function setPostContent(string $post_content): self
    {
        $this->post_content = $post_content;

        return $this;
    }

    public function getPostStatus(): ?string
    {
        return $this->post_status;
    }

    public function setPostStatus(string $post_status): self
    {
        $this->post_status = $post_status;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getPostAuthor(): ?User
    {
        return $this->post_author;
    }

    public function setPostAuthor(?User $post_author): self
    {
        $this->post_author = $post_author;

        return $this;
    }
}
