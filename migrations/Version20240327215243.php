<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327215243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE encounter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstteam_id INTEGER NOT NULL, secondteam_id INTEGER NOT NULL, event_id INTEGER NOT NULL, CONSTRAINT FK_69D229CA30AB9535 FOREIGN KEY (firstteam_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA256111B3 FOREIGN KEY (secondteam_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_69D229CA30AB9535 ON encounter (firstteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA256111B3 ON encounter (secondteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA71F7E88B ON encounter (event_id)');
        $this->addSql('CREATE TABLE encounter_tag (encounter_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(encounter_id, tag_id), CONSTRAINT FK_E7EEA315D6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E7EEA315BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E7EEA315D6E2FADC ON encounter_tag (encounter_id)');
        $this->addSql('CREATE INDEX IDX_E7EEA315BAD26311 ON encounter_tag (tag_id)');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, referent_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, startdate DATETIME NOT NULL, maximumcapacity INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, CONSTRAINT FK_3BAE0AA735E47E35 FOREIGN KEY (referent_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA735E47E35 ON event (referent_id)');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subtags_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, imageurl VARCHAR(255) NOT NULL, CONSTRAINT FK_389B783C619E77B FOREIGN KEY (subtags_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_389B783C619E77B ON tag (subtags_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, profilepicture VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE encounter');
        $this->addSql('DROP TABLE encounter_tag');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
