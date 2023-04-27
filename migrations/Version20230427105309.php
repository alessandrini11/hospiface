<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427105309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospitalization_room (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, hospitalization_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6CE299B754177093 (room_id), INDEX IDX_6CE299B75992429E (hospitalization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospitalization_room ADD CONSTRAINT FK_6CE299B754177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE hospitalization_room ADD CONSTRAINT FK_6CE299B75992429E FOREIGN KEY (hospitalization_id) REFERENCES hospitilization (id)');
        $this->addSql('ALTER TABLE hospitilization DROP FOREIGN KEY FK_FB17AA8954177093');
        $this->addSql('DROP INDEX IDX_FB17AA8954177093 ON hospitilization');
        $this->addSql('ALTER TABLE hospitilization DROP room_id');
        $this->addSql('ALTER TABLE room ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospitalization_room DROP FOREIGN KEY FK_6CE299B754177093');
        $this->addSql('ALTER TABLE hospitalization_room DROP FOREIGN KEY FK_6CE299B75992429E');
        $this->addSql('DROP TABLE hospitalization_room');
        $this->addSql('ALTER TABLE hospitilization ADD room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospitilization ADD CONSTRAINT FK_FB17AA8954177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_FB17AA8954177093 ON hospitilization (room_id)');
        $this->addSql('ALTER TABLE room DROP created_at, DROP updated_at');
    }
}
