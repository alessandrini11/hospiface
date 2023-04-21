<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421013516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE config_design (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, main_color VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_BB2E36F2B03A8386 (created_by_id), INDEX IDX_BB2E36F2896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE config_design ADD CONSTRAINT FK_BB2E36F2B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE config_design ADD CONSTRAINT FK_BB2E36F2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE drug ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE garde ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE hospitilization ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE medical_exams ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE medical_order ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE config_design DROP FOREIGN KEY FK_BB2E36F2B03A8386');
        $this->addSql('ALTER TABLE config_design DROP FOREIGN KEY FK_BB2E36F2896DBBDE');
        $this->addSql('DROP TABLE config_design');
        $this->addSql('ALTER TABLE drug DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE garde DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE hospitilization DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE medical_exams DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE medical_order DROP created_at, DROP updated_at');
    }
}
