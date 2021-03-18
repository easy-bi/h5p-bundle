<?php

namespace VCRoom\Bundle\CoreBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class CreateH5POptionTable implements Migration
{
    /**
     * {@inheritdoc}
     *
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries): void
    {
        self::addH5POptionTable($schema);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5POptionTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_option');

        $table->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $table->addColumn('value', 'text', ['notnull' => false]);
        $table->addColumn('type', 'string', ['length' => 255, 'notnull' => true]);

        $table->setPrimaryKey(['name']);
    }
}
