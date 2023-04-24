<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331133329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_post ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE feed_post ADD cover_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE feed_post ADD CONSTRAINT FK_DA1D87DAF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DA1D87DAF675F31B ON feed_post (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE feed_post DROP CONSTRAINT FK_DA1D87DAF675F31B');
        $this->addSql('DROP INDEX IDX_DA1D87DAF675F31B');
        $this->addSql('ALTER TABLE feed_post DROP author_id');
        $this->addSql('ALTER TABLE feed_post DROP cover_url');
    }
}
