<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324111637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD longitude DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE event ADD latitude DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE event DROP "position"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event ADD "position" TEXT NOT NULL');
        $this->addSql('ALTER TABLE event DROP longitude');
        $this->addSql('ALTER TABLE event DROP latitude');
        $this->addSql('COMMENT ON COLUMN event."position" IS \'(DC2Type:array)\'');
    }
}
