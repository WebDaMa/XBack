<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180107120505 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lodging_type (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_63AAAE9ACDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE all_in_type (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_3C5E3803CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travel_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE insurance_type (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_52FF1880CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lodging_type ADD CONSTRAINT FK_63AAAE9ACDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE all_in_type ADD CONSTRAINT FK_3C5E3803CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE insurance_type ADD CONSTRAINT FK_52FF1880CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE customer ADD lodging_type_id INT DEFAULT NULL, ADD all_in_type_id INT DEFAULT NULL, ADD insurance_type_id INT DEFAULT NULL, ADD travel_go_type_id INT DEFAULT NULL, ADD travel_back_type_id INT DEFAULT NULL, ADD payer_id_id INT DEFAULT NULL, DROP lodging_type, DROP all_in_type, DROP insurance_type, DROP travel_go_type, DROP travel_back_type, DROP payer_id');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09904223E4 FOREIGN KEY (lodging_type_id) REFERENCES lodging_type (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09FF4BBB5D FOREIGN KEY (all_in_type_id) REFERENCES all_in_type (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09286DA936 FOREIGN KEY (insurance_type_id) REFERENCES insurance_type (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09DEF86A5E FOREIGN KEY (travel_go_type_id) REFERENCES travel_type (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09633E720A FOREIGN KEY (travel_back_type_id) REFERENCES travel_type (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0950C2456A FOREIGN KEY (payer_id_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_81398E09904223E4 ON customer (lodging_type_id)');
        $this->addSql('CREATE INDEX IDX_81398E09FF4BBB5D ON customer (all_in_type_id)');
        $this->addSql('CREATE INDEX IDX_81398E09286DA936 ON customer (insurance_type_id)');
        $this->addSql('CREATE INDEX IDX_81398E09DEF86A5E ON customer (travel_go_type_id)');
        $this->addSql('CREATE INDEX IDX_81398E09633E720A ON customer (travel_back_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E0950C2456A ON customer (payer_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09904223E4');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09FF4BBB5D');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09DEF86A5E');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09633E720A');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09286DA936');
        $this->addSql('DROP TABLE lodging_type');
        $this->addSql('DROP TABLE all_in_type');
        $this->addSql('DROP TABLE travel_type');
        $this->addSql('DROP TABLE insurance_type');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E0950C2456A');
        $this->addSql('DROP INDEX IDX_81398E09904223E4 ON customer');
        $this->addSql('DROP INDEX IDX_81398E09FF4BBB5D ON customer');
        $this->addSql('DROP INDEX IDX_81398E09286DA936 ON customer');
        $this->addSql('DROP INDEX IDX_81398E09DEF86A5E ON customer');
        $this->addSql('DROP INDEX IDX_81398E09633E720A ON customer');
        $this->addSql('DROP INDEX UNIQ_81398E0950C2456A ON customer');
        $this->addSql('ALTER TABLE customer ADD lodging_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD all_in_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD insurance_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD travel_go_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD travel_back_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD payer_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP lodging_type_id, DROP all_in_type_id, DROP insurance_type_id, DROP travel_go_type_id, DROP travel_back_type_id, DROP payer_id_id');
    }
}
