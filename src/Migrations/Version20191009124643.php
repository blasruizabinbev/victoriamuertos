<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009124643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile ADD image VARCHAR(255) DEFAULT NULL, ADD offer_name VARCHAR(255) DEFAULT NULL, ADD offer_variation INT DEFAULT NULL');
        $this->addSql('CREATE TABLE sessions (sess_id varchar(128) COLLATE utf8_bin NOT NULL, sess_data longtext COLLATE utf8_bin NOT NULL, sess_time int(10) unsigned NOT NULL, sess_lifetime mediumint(9) NOT NULL, PRIMARY KEY (sess_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile DROP image, DROP offer_name, DROP offer_variation');
        $this->addSql('DROP TABLE sessions');
    }
}
