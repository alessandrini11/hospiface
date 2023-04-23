<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423000732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_964685A6B03A8386 ON consultation (created_by_id)');
        $this->addSql('CREATE INDEX IDX_964685A6896DBBDE ON consultation (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6B03A8386');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6896DBBDE');
        $this->addSql('DROP INDEX IDX_964685A6B03A8386 ON consultation');
        $this->addSql('DROP INDEX IDX_964685A6896DBBDE ON consultation');
        $this->addSql('ALTER TABLE consultation DROP created_by_id, DROP updated_by_id');
    }
}
