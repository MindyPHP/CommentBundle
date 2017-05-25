<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Mindy\Bundle\CommentBundle\Model\Comment;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170510080215 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $commentTable = $schema->createTable(Comment::tableName());
        $commentTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true, 'length' => 11]);
        $commentTable->addColumn('object_type', 'string', ['length' => 255]);
        $commentTable->addColumn('object_id', 'integer', ['length' => 11]);
        $commentTable->addColumn('username', 'string', ['length' => 255, 'notnull' => false]);
        $commentTable->addColumn('email', 'string', ['length' => 255, 'notnull' => false]);
        $commentTable->addColumn('phone', 'string', ['length' => 255, 'notnull' => false]);
        $commentTable->addColumn('comment', 'text');
        $commentTable->addColumn('user_id', 'integer', ['length' => 11, 'default' => 0, 'notnull' => false]);
        $commentTable->addColumn('is_published', 'smallint', ['length' => 1, 'default' => 0]);
        $commentTable->addColumn('created_at', 'datetime');
        $commentTable->addColumn('parent_id', 'integer', ['length' => 11, 'notnull' => false]);
        $commentTable->addColumn('lft', 'integer', ['length' => 11]);
        $commentTable->addColumn('rgt', 'integer', ['length' => 11]);
        $commentTable->addColumn('root', 'integer', ['length' => 11, 'notnull' => false]);
        $commentTable->addColumn('level', 'integer', ['length' => 11]);
        $commentTable->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable(Comment::tableName());
    }
}
