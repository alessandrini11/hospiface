<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421005940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, parameter_id INT DEFAULT NULL, result_id INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_964685A687F4FB17 (doctor_id), INDEX IDX_964685A66B899279 (patient_id), UNIQUE INDEX UNIQ_964685A67C56DBD6 (parameter_id), UNIQUE INDEX UNIQ_964685A67A7B643 (result_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, temparature DOUBLE PRECISION DEFAULT NULL, blood_pressure DOUBLE PRECISION DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_ACC79041B03A8386 (created_by_id), INDEX IDX_ACC79041896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, interpretation LONGTEXT DEFAULT NULL, INDEX IDX_136AC113B03A8386 (created_by_id), INDEX IDX_136AC113896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A687F4FB17 FOREIGN KEY (doctor_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A67C56DBD6 FOREIGN KEY (parameter_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A67A7B643 FOREIGN KEY (result_id) REFERENCES result (id)');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A687F4FB17');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A67C56DBD6');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A67A7B643');
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041B03A8386');
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041896DBBDE');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113B03A8386');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113896DBBDE');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE parametre');
        $this->addSql('DROP TABLE result');
    }
}
