<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Create Language Keywords Table Migration
 * 
 * Creates the language_keywords table for managing multilingual keywords
 * and their translations
 * 
 * @package App\Database\Migrations
 */
class CreateLanguageKeywordsTable extends Migration
{
    /**
     * Run the migration
     * 
     * @return void
     */
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Unique keyword identifier'
            ],
            'module' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'comment' => 'Module name where keyword is used'
            ],
            'en_translation' => [
                'type' => 'TEXT',
                'null' => false,
                'comment' => 'English translation text'
            ],
            'vi_translation' => [
                'type' => 'TEXT',
                'null' => false,
                'comment' => 'Vietnamese translation text'
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Description or context for the keyword'
            ],
            'order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Sorting order'
            ],
            'publish' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => 'Publish status: 1 = published, 0 = unpublished'
            ],
            'userid_created' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'User ID who created the record'
            ],
            'userid_updated' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'User ID who last updated the record'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Record creation timestamp'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Record last update timestamp'
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Soft delete timestamp'
            ]
        ]);

        // Add primary key
        $this->forge->addKey('id', true);
        
        // Add unique constraint for keyword
        $this->forge->addUniqueKey('keyword');
        
        // Add indexes for better performance
        $this->forge->addKey('module');
        $this->forge->addKey('publish');
        $this->forge->addKey('order');
        $this->forge->addKey('created_at');
        
        // Add fulltext index for search functionality
        $this->forge->addKey(['keyword', 'en_translation', 'vi_translation', 'description'], 'fulltext_search', 'FULLTEXT');
        
        // Create the table
        $this->forge->createTable('language_keywords', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ]);
    }

    /**
     * Reverse the migration
     * 
     * @return void
     */
    public function down(): void
    {
        $this->forge->dropTable('language_keywords', true);
    }
}
