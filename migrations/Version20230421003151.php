<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421003151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garde (id INT AUTO_INCREMENT NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2B03A8386 ON service (created_by_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2896DBBDE ON service (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE garde');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2B03A8386');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2896DBBDE');
        $this->addSql('DROP INDEX IDX_E19D9AD2B03A8386 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD2896DBBDE ON service');
        $this->addSql('ALTER TABLE service DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
