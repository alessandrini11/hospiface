<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421011734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, medical_order_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, dosage VARCHAR(255) DEFAULT NULL, alternative TINYINT(1) DEFAULT NULL, INDEX IDX_43EB7A3EF105806F (medical_order_id), INDEX IDX_43EB7A3EB03A8386 (created_by_id), INDEX IDX_43EB7A3E896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_exams (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, result_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_5CD74878B03A8386 (created_by_id), INDEX IDX_5CD74878896DBBDE (updated_by_id), INDEX IDX_5CD748787A7B643 (result_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_order (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, INDEX IDX_C0CFC8C8B03A8386 (created_by_id), INDEX IDX_C0CFC8C8896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drug ADD CONSTRAINT FK_43EB7A3EF105806F FOREIGN KEY (medical_order_id) REFERENCES medical_order (id)');
        $this->addSql('ALTER TABLE drug ADD CONSTRAINT FK_43EB7A3EB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE drug ADD CONSTRAINT FK_43EB7A3E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medical_exams ADD CONSTRAINT FK_5CD74878B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medical_exams ADD CONSTRAINT FK_5CD74878896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medical_exams ADD CONSTRAINT FK_5CD748787A7B643 FOREIGN KEY (result_id) REFERENCES result (id)');
        $this->addSql('ALTER TABLE medical_order ADD CONSTRAINT FK_C0CFC8C8B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medical_order ADD CONSTRAINT FK_C0CFC8C8896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE result ADD medical_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113F105806F FOREIGN KEY (medical_order_id) REFERENCES medical_order (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_136AC113F105806F ON result (medical_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113F105806F');
        $this->addSql('ALTER TABLE drug DROP FOREIGN KEY FK_43EB7A3EF105806F');
        $this->addSql('ALTER TABLE drug DROP FOREIGN KEY FK_43EB7A3EB03A8386');
        $this->addSql('ALTER TABLE drug DROP FOREIGN KEY FK_43EB7A3E896DBBDE');
        $this->addSql('ALTER TABLE medical_exams DROP FOREIGN KEY FK_5CD74878B03A8386');
        $this->addSql('ALTER TABLE medical_exams DROP FOREIGN KEY FK_5CD74878896DBBDE');
        $this->addSql('ALTER TABLE medical_exams DROP FOREIGN KEY FK_5CD748787A7B643');
        $this->addSql('ALTER TABLE medical_order DROP FOREIGN KEY FK_C0CFC8C8B03A8386');
        $this->addSql('ALTER TABLE medical_order DROP FOREIGN KEY FK_C0CFC8C8896DBBDE');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE medical_exams');
        $this->addSql('DROP TABLE medical_order');
        $this->addSql('DROP INDEX UNIQ_136AC113F105806F ON result');
        $this->addSql('ALTER TABLE result DROP medical_order_id');
    }
}
