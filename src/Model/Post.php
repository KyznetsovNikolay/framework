<?php

namespace App\Model;

class Post
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var \DateTimeImmutable
     */
    public \DateTimeImmutable $date;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $content;

    public function __construct(int $id, \DateTimeImmutable $date, string $title, string $content)
    {
        $this->id = $id;
        $this->date = $date;
        $this->title = $title;
        $this->content = $content;
    }
}
