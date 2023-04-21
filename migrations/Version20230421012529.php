<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421012529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospitilization (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, room_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_FB17AA896B899279 (patient_id), INDEX IDX_FB17AA8954177093 (room_id), INDEX IDX_FB17AA89B03A8386 (created_by_id), INDEX IDX_FB17AA89896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, beds INT DEFAULT NULL, INDEX IDX_729F519BB03A8386 (created_by_id), INDEX IDX_729F519B896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospitilization ADD CONSTRAINT FK_FB17AA896B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE hospitilization ADD CONSTRAINT FK_FB17AA8954177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE hospitilization ADD CONSTRAINT FK_FB17AA89B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE hospitilization ADD CONSTRAINT FK_FB17AA89896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospitilization DROP FOREIGN KEY FK_FB17AA896B899279');
        $this->addSql('ALTER TABLE hospitilization DROP FOREIGN KEY FK_FB17AA8954177093');
        $this->addSql('ALTER TABLE hospitilization DROP FOREIGN KEY FK_FB17AA89B03A8386');
        $this->addSql('ALTER TABLE hospitilization DROP FOREIGN KEY FK_FB17AA89896DBBDE');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BB03A8386');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B896DBBDE');
        $this->addSql('DROP TABLE hospitilization');
        $this->addSql('DROP TABLE room');
    }
}
