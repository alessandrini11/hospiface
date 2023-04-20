<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420234610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, birth_date DATETIME DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, position_held VARCHAR(255) DEFAULT NULL, sub_type VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phonenumber VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A6BCF3DEE7927C74 (email), INDEX IDX_A6BCF3DEB03A8386 (created_by_id), INDEX IDX_A6BCF3DE896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEB03A8386');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE896DBBDE');
        $this->addSql('DROP TABLE personnel');
    }
}
