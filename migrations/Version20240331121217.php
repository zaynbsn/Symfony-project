<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331121217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT referent_id, id, description, startdate, maximumcapacity, address, location FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id VARCHAR(255) NOT NULL, referent_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, startdate DATETIME NOT NULL, maximumcapacity INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_3BAE0AA735E47E35 FOREIGN KEY (referent_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (referent_id, id, description, startdate, maximumcapacity, address, location) SELECT referent_id, id, description, startdate, maximumcapacity, address, location FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA735E47E35 ON event (referent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, referent_id, description, startdate, location, maximumcapacity, address FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (referent_id INTEGER NOT NULL, id VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, startdate DATETIME NOT NULL, location VARCHAR(255) NOT NULL, maximumcapacity INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, CONSTRAINT FK_3BAE0AA735E47E35 FOREIGN KEY (referent_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, referent_id, description, startdate, location, maximumcapacity, address) SELECT id, referent_id, description, startdate, location, maximumcapacity, address FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA735E47E35 ON event (referent_id)');
    }
}
