<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Post;
use PDO;

class PostRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(id) FROM posts');
        return (int)$stmt->fetchColumn();
    }

    /**
     * @return Post[]
     */
    public function getAll(int $offset, int $limit): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return array_map([$this, 'hydratePost'], $stmt->fetchAll());
    }

    public function find($id): ?Post
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return ($row = $stmt->fetch()) ? $this->hydratePost($row) : null;
    }

    private function hydratePost(array $row): Post
    {
        return new Post(
            (int)$row['id'],
            new \DateTimeImmutable($row['date']),
            $row['title'],
            $row['content']
        );
    }
}
