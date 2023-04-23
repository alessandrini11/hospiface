<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423170052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garde ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE garde ADD CONSTRAINT FK_5964B6CB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE garde ADD CONSTRAINT FK_5964B6C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_5964B6CB03A8386 ON garde (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5964B6C896DBBDE ON garde (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garde DROP FOREIGN KEY FK_5964B6CB03A8386');
        $this->addSql('ALTER TABLE garde DROP FOREIGN KEY FK_5964B6C896DBBDE');
        $this->addSql('DROP INDEX IDX_5964B6CB03A8386 ON garde');
        $this->addSql('DROP INDEX IDX_5964B6C896DBBDE ON garde');
        $this->addSql('ALTER TABLE garde DROP created_by_id, DROP updated_by_id');
    }
}
