<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420235432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_F3D7A08EB03A8386 (created_by_id), INDEX IDX_F3D7A08E896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08EB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE personnel ADD speciality_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DE3B5A08D7 ON personnel (speciality_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE3B5A08D7');
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08EB03A8386');
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08E896DBBDE');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP INDEX IDX_A6BCF3DE3B5A08D7 ON personnel');
        $this->addSql('ALTER TABLE personnel DROP speciality_id');
    }
}
