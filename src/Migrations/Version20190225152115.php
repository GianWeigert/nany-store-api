<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190225152115 extends AbstractMigration
{
    private const IS_NOT_MYSQL_MESSAGE = 'Migration can only be executed safely on \'mysql\'';

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->isMysql(), self::IS_NOT_MYSQL_MESSAGE);
        $categoryTable = $schema->createTable("category");

        $categoryTable->addColumn(
            'id',
            'integer',
            [
                'autoincrement' => true,
                'notnull' => true
            ]
        );

        $categoryTable->addColumn(
            'name',
            'string',
            [
                'length' => 255,
                'notnull' => true
            ]
        );

        $categoryTable->addColumn(
            'slug',
            'string',
            [
                'length' => 255,
                'notnull' => true
            ]
        );

        $categoryTable->addColumn(
            'enabled',
            'boolean',
            [
                'notnull' => true
            ]
        );

        $categoryTable->addColumn(
            'created_at',
            'datetime',
            [
                'notnull' => true
            ]
        );

        $categoryTable->addColumn(
            'updated_at',
            'datetime',
            [
                'notnull' => true
            ]
        );

        $categoryTable->setPrimaryKey(['id']);
        $categoryTable->addUniqueIndex(['name']);
        $categoryTable->addUniqueIndex(['slug']);
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->isMysql(), self::IS_NOT_MYSQL_MESSAGE);

        $categoryTable = $schema->dropTable("category");
    }

    private function isMysql(): bool
    {
        $databasePlataformName = $this->connection->getDatabasePlatform()->getName();

        return $databasePlataformName !== 'mysql';
    }
}
