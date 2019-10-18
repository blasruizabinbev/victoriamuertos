<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009125027 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile CHANGE question_one_answer question_one_answer INT DEFAULT NULL, CHANGE question_two_answer question_two_answer INT DEFAULT NULL, CHANGE question_three_answer question_three_answer INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile CHANGE question_one_answer question_one_answer VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE question_two_answer question_two_answer VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE question_three_answer question_three_answer VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
