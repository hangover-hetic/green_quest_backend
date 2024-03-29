<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503163437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE participation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE participation (id INT NOT NULL, event_id INT NOT NULL, user_id_id INT NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB55E24F71F7E88B ON participation (event_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F9D86650F ON participation (user_id_id)');
        $this->addSql('COMMENT ON COLUMN participation.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE participation_id_seq CASCADE');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT FK_AB55E24F71F7E88B');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT FK_AB55E24F9D86650F');
        $this->addSql('DROP TABLE participation');
    }
}
