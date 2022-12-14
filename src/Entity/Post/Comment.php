<?php

declare(strict_types=1);

namespace App\Entity\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $date;

    /**
     * @ORM\Column(type="string")
     */
    private string $author;

    /**
     * @ORM\Column(type="text")
     */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Post $post;

    public function __construct(Post $post, \DateTimeImmutable $date, string $author, string $text)
    {
        $this->post = $post;
        $this->date = $date;
        $this->author = $author;
        $this->text = $text;
    }

    public function edit($text): void
    {
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
