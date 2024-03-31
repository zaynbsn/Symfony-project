<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331120922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__encounter AS SELECT id, firstteam_id, secondteam_id, event_id FROM encounter');
        $this->addSql('DROP TABLE encounter');
        $this->addSql('CREATE TABLE encounter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstteam_id INTEGER NOT NULL, secondteam_id INTEGER NOT NULL, event_id VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_69D229CA30AB9535 FOREIGN KEY (firstteam_id) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA256111B3 FOREIGN KEY (secondteam_id) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO encounter (id, firstteam_id, secondteam_id, event_id) SELECT id, firstteam_id, secondteam_id, event_id FROM __temp__encounter');
        $this->addSql('DROP TABLE __temp__encounter');
        $this->addSql('CREATE INDEX IDX_69D229CA71F7E88B ON encounter (event_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA256111B3 ON encounter (secondteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA30AB9535 ON encounter (firstteam_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, referent_id, description, startdate, maximumcapacity, address, location FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id VARCHAR(255) NOT NULL, referent_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, startdate DATETIME NOT NULL, maximumcapacity INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, CONSTRAINT FK_3BAE0AA735E47E35 FOREIGN KEY (referent_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, referent_id, description, startdate, maximumcapacity, address, location) SELECT id, referent_id, description, startdate, maximumcapacity, address, location FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA735E47E35 ON event (referent_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event_user AS SELECT event_id, user_id FROM event_user');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('CREATE TABLE event_user (event_id VARCHAR(255) NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(event_id, user_id), CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event_user (event_id, user_id) SELECT event_id, user_id FROM __temp__event_user');
        $this->addSql('DROP TABLE __temp__event_user');
        $this->addSql('CREATE INDEX IDX_92589AE2A76ED395 ON event_user (user_id)');
        $this->addSql('CREATE INDEX IDX_92589AE271F7E88B ON event_user (event_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, lastname, firstname, username, email, birthdate, profilepicture, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, birthdate DATE NOT NULL, profilepicture VARCHAR(255) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, lastname, firstname, username, email, birthdate, profilepicture, roles, password) SELECT id, lastname, firstname, username, email, birthdate, profilepicture, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__encounter AS SELECT id, firstteam_id, secondteam_id, event_id FROM encounter');
        $this->addSql('DROP TABLE encounter');
        $this->addSql('CREATE TABLE encounter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstteam_id INTEGER NOT NULL, secondteam_id INTEGER NOT NULL, event_id INTEGER NOT NULL, CONSTRAINT FK_69D229CA30AB9535 FOREIGN KEY (firstteam_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA256111B3 FOREIGN KEY (secondteam_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO encounter (id, firstteam_id, secondteam_id, event_id) SELECT id, firstteam_id, secondteam_id, event_id FROM __temp__encounter');
        $this->addSql('DROP TABLE __temp__encounter');
        $this->addSql('CREATE INDEX IDX_69D229CA30AB9535 ON encounter (firstteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA256111B3 ON encounter (secondteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA71F7E88B ON encounter (event_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, referent_id, description, startdate, location, maximumcapacity, address FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, referent_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, startdate DATETIME NOT NULL, location VARCHAR(255) NOT NULL, maximumcapacity INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, CONSTRAINT FK_3BAE0AA735E47E35 FOREIGN KEY (referent_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, referent_id, description, startdate, location, maximumcapacity, address) SELECT id, referent_id, description, startdate, location, maximumcapacity, address FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA735E47E35 ON event (referent_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event_user AS SELECT event_id, user_id FROM event_user');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('CREATE TABLE event_user (event_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(event_id, user_id), CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event_user (event_id, user_id) SELECT event_id, user_id FROM __temp__event_user');
        $this->addSql('DROP TABLE __temp__event_user');
        $this->addSql('CREATE INDEX IDX_92589AE271F7E88B ON event_user (event_id)');
        $this->addSql('CREATE INDEX IDX_92589AE2A76ED395 ON event_user (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, lastname, firstname, username, birthdate, profilepicture FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, profilepicture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, lastname, firstname, username, birthdate, profilepicture) SELECT id, email, roles, password, lastname, firstname, username, birthdate, profilepicture FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
