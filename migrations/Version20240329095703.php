<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329095703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, lastname, firstname, username, email, birthdate, profilepicture FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, birthdate DATE NOT NULL, profilepicture VARCHAR(255) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, lastname, firstname, username, email, birthdate, profilepicture) SELECT id, lastname, firstname, username, email, birthdate, profilepicture FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, lastname, firstname, username, birthdate, profilepicture FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, profilepicture VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, lastname, firstname, username, birthdate, profilepicture) SELECT id, email, lastname, firstname, username, birthdate, profilepicture FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
