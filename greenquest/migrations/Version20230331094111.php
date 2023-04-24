<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331094111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE feed_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE feed_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE feed (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE feed_post (id INT NOT NULL, feed_id INT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA1D87DA51A5BC03 ON feed_post (feed_id)');
        $this->addSql('ALTER TABLE feed_post ADD CONSTRAINT FK_DA1D87DA51A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE feed_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE feed_post_id_seq CASCADE');
        $this->addSql('ALTER TABLE feed_post DROP CONSTRAINT FK_DA1D87DA51A5BC03');
        $this->addSql('DROP TABLE feed');
        $this->addSql('DROP TABLE feed_post');
    }
}
