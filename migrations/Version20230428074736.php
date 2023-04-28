<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428074736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospitalization_room DROP FOREIGN KEY FK_6CE299B75992429E');
        $this->addSql('DROP INDEX IDX_6CE299B75992429E ON hospitalization_room');
        $this->addSql('ALTER TABLE hospitalization_room DROP hospitalization_id');
        $this->addSql('ALTER TABLE hospitilization ADD hospitalization_room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospitilization ADD CONSTRAINT FK_FB17AA8948D79FCE FOREIGN KEY (hospitalization_room_id) REFERENCES hospitalization_room (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB17AA8948D79FCE ON hospitilization (hospitalization_room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospitalization_room ADD hospitalization_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospitalization_room ADD CONSTRAINT FK_6CE299B75992429E FOREIGN KEY (hospitalization_id) REFERENCES hospitilization (id)');
        $this->addSql('CREATE INDEX IDX_6CE299B75992429E ON hospitalization_room (hospitalization_id)');
        $this->addSql('ALTER TABLE hospitilization DROP FOREIGN KEY FK_FB17AA8948D79FCE');
        $this->addSql('DROP INDEX UNIQ_FB17AA8948D79FCE ON hospitilization');
        $this->addSql('ALTER TABLE hospitilization DROP hospitalization_room_id');
    }
}
