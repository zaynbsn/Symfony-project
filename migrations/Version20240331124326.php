<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331124326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE encounter ADD COLUMN description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__encounter AS SELECT id, firstteam_id, secondteam_id, event_id FROM encounter');
        $this->addSql('DROP TABLE encounter');
        $this->addSql('CREATE TABLE encounter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstteam_id INTEGER NOT NULL, secondteam_id INTEGER NOT NULL, event_id VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_69D229CA30AB9535 FOREIGN KEY (firstteam_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA256111B3 FOREIGN KEY (secondteam_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69D229CA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO encounter (id, firstteam_id, secondteam_id, event_id) SELECT id, firstteam_id, secondteam_id, event_id FROM __temp__encounter');
        $this->addSql('DROP TABLE __temp__encounter');
        $this->addSql('CREATE INDEX IDX_69D229CA30AB9535 ON encounter (firstteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA256111B3 ON encounter (secondteam_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA71F7E88B ON encounter (event_id)');
    }
}
