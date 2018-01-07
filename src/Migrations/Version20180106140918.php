<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180106140918 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE program_type (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_8138022ECDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_type ADD CONSTRAINT FK_8138022ECDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE customer ADD program_type_id INT DEFAULT NULL, DROP program_type');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E094EA67447 FOREIGN KEY (program_type_id) REFERENCES program_type (id)');
        $this->addSql('CREATE INDEX IDX_81398E094EA67447 ON customer (program_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E094EA67447');
        $this->addSql('DROP TABLE program_type');
        $this->addSql('DROP INDEX IDX_81398E094EA67447 ON customer');
        $this->addSql('ALTER TABLE customer ADD program_type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP program_type_id');
    }
}
