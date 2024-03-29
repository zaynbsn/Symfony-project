<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329085716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD COLUMN location VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tag ADD COLUMN type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, referent_id, description, startdate, maximumcapacity, address FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, referent_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, startdate DATETIME NOT NULL, maximumcapacity INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, CONSTRAINT FK_3BAE0AA735E47E35 FOREIGN KEY (referent_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, referent_id, description, startdate, maximumcapacity, address) SELECT id, referent_id, description, startdate, maximumcapacity, address FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA735E47E35 ON event (referent_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, subtags_id, name, imageurl FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subtags_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, imageurl VARCHAR(255) NOT NULL, CONSTRAINT FK_389B783C619E77B FOREIGN KEY (subtags_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tag (id, subtags_id, name, imageurl) SELECT id, subtags_id, name, imageurl FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('CREATE INDEX IDX_389B783C619E77B ON tag (subtags_id)');
    }
}
