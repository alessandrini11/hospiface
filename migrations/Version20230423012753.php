<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423012753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel_service ADD created_by_id INT DEFAULT NULL, ADD update_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel_service ADD CONSTRAINT FK_41BB86FDB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE personnel_service ADD CONSTRAINT FK_41BB86FDCA83C286 FOREIGN KEY (update_by_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_41BB86FDB03A8386 ON personnel_service (created_by_id)');
        $this->addSql('CREATE INDEX IDX_41BB86FDCA83C286 ON personnel_service (update_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel_service DROP FOREIGN KEY FK_41BB86FDB03A8386');
        $this->addSql('ALTER TABLE personnel_service DROP FOREIGN KEY FK_41BB86FDCA83C286');
        $this->addSql('DROP INDEX IDX_41BB86FDB03A8386 ON personnel_service');
        $this->addSql('DROP INDEX IDX_41BB86FDCA83C286 ON personnel_service');
        $this->addSql('ALTER TABLE personnel_service DROP created_by_id, DROP update_by_id');
    }
}
