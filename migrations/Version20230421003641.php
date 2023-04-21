<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421003641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnel_garde (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, service_id INT DEFAULT NULL, garde_id INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_225F20D21C109075 (personnel_id), INDEX IDX_225F20D2ED5CA9E6 (service_id), INDEX IDX_225F20D22D6D57CE (garde_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personnel_garde ADD CONSTRAINT FK_225F20D21C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE personnel_garde ADD CONSTRAINT FK_225F20D2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE personnel_garde ADD CONSTRAINT FK_225F20D22D6D57CE FOREIGN KEY (garde_id) REFERENCES garde (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel_garde DROP FOREIGN KEY FK_225F20D21C109075');
        $this->addSql('ALTER TABLE personnel_garde DROP FOREIGN KEY FK_225F20D2ED5CA9E6');
        $this->addSql('ALTER TABLE personnel_garde DROP FOREIGN KEY FK_225F20D22D6D57CE');
        $this->addSql('DROP TABLE personnel_garde');
    }
}
