<?php

namespace VCRoom\Bundle\CoreBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class CreateH5PTables implements Migration
{
    /**
     * {@inheritdoc}
     *
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries): void
    {
        self::addH5POptionTable($schema);
        self::addH5PContentTable($schema);
        self::addH5PContentResultTable($schema);
        self::addH5PContentUserDataTable($schema);
        self::addH5PCountersTable($schema);
        self::addH5PEventTable($schema);
        self::addH5PLibrariesHubCacheTable($schema);
        self::addH5PLibrariesLanguagesTable($schema);
        self::addH5PLibraryTable($schema);
        self::addH5PLibraryLibrariesTable($schema);
        self::addH5PPointsTable($schema);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5POptionTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_option');

        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('value', 'text');
        $table->addColumn('type', 'string', ['length' => 255]);

        $table->setPrimaryKey(['name']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PContentTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_content');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('library_id', 'integer');
        $table->addColumn('parameters', 'text', ['notnull' => false]);
        $table->addColumn('filtered_parameters', 'text', ['notnull' => false]);
        $table->addColumn('disabled_features', 'integer', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PContentResultTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_content_result');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('content_id', 'integer');
        $table->addColumn('userid', 'integer', ['notnull' => true]);
        $table->addColumn('score', 'integer', ['notnull' => false]);
        $table->addColumn('maxscore', 'integer', ['notnull' => false]);
        $table->addColumn('opened', 'integer', ['notnull' => false]);
        $table->addColumn('finished', 'integer', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PContentUserDataTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_content_user_data');

        $table->addColumn('user_id', 'integer');
        $table->addColumn('content_main_id', 'integer');
        $table->addColumn('sub_content_id', 'integer', ['length' => 10]);
        $table->addColumn('data_id', 'string', ['length' => 127]);
        $table->addColumn('timestamp', 'string', ['length' => 10]);
        $table->addColumn('data', 'text');
        $table->addColumn('preloaded', 'boolean', ['notnull' => false]);
        $table->addColumn('delete_on_content_change', 'boolean', ['notnull' => false]);

        $table->setPrimaryKey(['user_id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PCountersTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_counters');

        $table->addColumn('type', 'string', ['length' => 63]);
        $table->addColumn('library_name', 'string', ['length' => 127]);
        $table->addColumn('library_version', 'string', ['length' => 31]);
        $table->addColumn('num', 'integer');

        $table->setPrimaryKey(['type']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PEventTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_event');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('type', 'string', ['length' => 63]);
        $table->addColumn('sub_type', 'string', ['length' => 63]);
        $table->addColumn('content_id', 'integer');
        $table->addColumn('content_title', 'string', ['length' => 255]);
        $table->addColumn('library_name', 'string', ['length' => 127]);
        $table->addColumn('library_version', 'string', ['length' => 31]);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PLibrariesHubCacheTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_libraries_hub_cache');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('machine_name', 'string', ['length' => 127]);
        $table->addColumn('major_version', 'integer');
        $table->addColumn('minor_version', 'integer');
        $table->addColumn('patch_version', 'integer');
        $table->addColumn('h5p_major_version', 'integer', ['notnull' => false]);
        $table->addColumn('h5p_minor_version', 'integer', ['notnull' => false]);
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('summary', 'text');
        $table->addColumn('description', 'text');
        $table->addColumn('icon', 'text');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->addColumn('is_recommended', 'boolean', ['default' => true]);
        $table->addColumn('popularity', 'integer');
        $table->addColumn('screenshots', 'text', ['notnull' => false]);
        $table->addColumn('license', 'text', ['notnull' => false]);
        $table->addColumn('example', 'text');
        $table->addColumn('tutorial', 'text', ['notnull' => false]);
        $table->addColumn('keywords', 'text', ['notnull' => false]);
        $table->addColumn('categories', 'text', ['notnull' => false]);
        $table->addColumn('owner', 'text', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PLibrariesLanguagesTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_libraries_languages');

        $table->addColumn('library_id', 'integer');
        $table->addColumn('language_code', 'string', ['length' => 31]);
        $table->addColumn('language_json', 'text');

        $table->setPrimaryKey(['library_id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PLibraryTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_library');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('machine_name', 'string', ['length' => 127]);
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('major_version', 'integer');
        $table->addColumn('minor_version', 'integer');
        $table->addColumn('patch_version', 'integer');
        $table->addColumn('runnable', 'boolean', ['default' => true]);
        $table->addColumn('fullscreen', 'boolean', ['default' => false]);
        $table->addColumn('embed_types', 'string', ['length' => 255]);
        $table->addColumn('preloaded_js', 'text', ['notnull' => false]);
        $table->addColumn('preloaded_css', 'text', ['notnull' => false]);
        $table->addColumn('drop_library_css', 'text', ['notnull' => false]);
        $table->addColumn('semantics', 'text');
        $table->addColumn('restricted', 'boolean', ['default' => false]);
        $table->addColumn('tutorial_url', 'string', ['length' => 1000, 'notnull' => false]);
        $table->addColumn('has_icon', 'boolean', ['default' => false]);
        $table->addColumn('metadata_settings', 'text', ['notnull' => false]);
        $table->addColumn('add_to', 'text', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PLibraryLibrariesTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_library_libraries');

        $table->addColumn('library_id', 'integer');
        $table->addColumn('required_library_id', 'integer');
        $table->addColumn('dependency_type', 'string', ['length' => 31]);

        $table->setPrimaryKey(['library_id']);
    }

    /**
     * @param Schema $schema
     */
    public static function addH5PPointsTable(Schema $schema): void
    {
        $table = $schema->createTable('h5p_points');

        $table->addColumn('user_id', 'integer');
        $table->addColumn('content_main_id', 'integer');
        $table->addColumn('started', 'integer');
        $table->addColumn('finished', 'integer');
        $table->addColumn('points', 'integer', ['notnull' => false]);
        $table->addColumn('max_points', 'integer', ['notnull' => false]);

        $table->setPrimaryKey(['content_main_id']);
    }
}
