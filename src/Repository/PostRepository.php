<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Post;

class PostRepository
{
    private array $posts;

    public function __construct()
    {
        $this->posts = [
            new Post(1, new \DateTimeImmutable(), 'The First Post', 'The First Post Content'),
            new Post(2, new \DateTimeImmutable(), 'The Second Post', 'The Second Post Content'),
        ];
    }

    /**
     * @return Post[]
     */
    public function getAll(): array
    {
        return array_reverse($this->posts);
    }

    public function find($id): ?Post
    {
        foreach ($this->posts as $post) {
            if ($post->id === (int)$id) {
                return $post;
            }
        }
        return null;
    }
}
