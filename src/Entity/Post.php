<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     * @Assert\Length(
     *  min = 10,
     *  max = 4096
     * )
     */
    private $post_title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $post_slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *  min = 10,
     *  max = 4096
     * )
     */
    private $post_content;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('post', 'page')")
     */
    private $post_type = "post";

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('draft', 'pending', 'active', 'inactive', 'trashed')")
     */
    private $post_status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $post_thumbnail;

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

    /**
     * @ORM\ManyToOne(targetEntity=PostCategory::class, inversedBy="posts")
     */
    private $post_category;

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

    public function getPostSlug(): ?string
    {
        return $this->post_slug;
    }

    public function setPostSlug(string $post_slug): self
    {
        $this->post_slug = $post_slug;

        return $this;
    }

    public function getPostType(): ?string
    {
        return $this->post_type;
    }

    public function setPostType(string $post_type): self
    {
        $this->post_type = $post_type;

        return $this;
    }

    public function getPostCategory(): ?PostCategory
    {
        return $this->post_category;
    }

    public function setPostCategory(?PostCategory $post_category): self
    {
        $this->post_category = $post_category;

        return $this;
    }

    public function getPostThumbnail(): ?string
    {
        return "/uploads/posts/$this->post_thumbnail";
    }

    public function setPostThumbnail(?string $post_thumbnail): self
    {
        $this->post_thumbnail = $post_thumbnail;

        return $this;
    }
}
