<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PostsTable extends AbstractMigration
{
    public function up(): void
    {
        $users = $this->table('posts');
        $users
            ->addColumn('date', 'datetime')
            ->addColumn('title', 'string', ['limit' => 100])
            ->addColumn('content', 'text')
            ->create();
    }

    public function down()
    {
        $this
            ->table('posts')
            ->drop()
            ->save();
    }
}
