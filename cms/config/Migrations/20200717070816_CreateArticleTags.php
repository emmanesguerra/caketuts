<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateArticleTags extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('articles_tags', ['id' => false, 'primary_key' => ['article_id', 'tag_id']]);
        $table->addColumn('article_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('tag_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addForeignKey('tag_id', 'tags', ['id'], ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'tag_key']);
        $table->addForeignKey('article_id', 'articles', ['id'], ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'article_key']);
        $table->create();
    }
}
