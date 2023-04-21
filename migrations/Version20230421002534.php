<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421002534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnel_service (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, service_id INT NOT NULL, position_held VARCHAR(255) DEFAULT NULL, INDEX IDX_41BB86FD1C109075 (personnel_id), INDEX IDX_41BB86FDED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personnel_service ADD CONSTRAINT FK_41BB86FD1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE personnel_service ADD CONSTRAINT FK_41BB86FDED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel_service DROP FOREIGN KEY FK_41BB86FD1C109075');
        $this->addSql('ALTER TABLE personnel_service DROP FOREIGN KEY FK_41BB86FDED5CA9E6');
        $this->addSql('DROP TABLE personnel_service');
    }
}
