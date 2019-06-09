<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180125181011 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE boupload (id INT AUTO_INCREMENT NOT NULL, bo_period_file VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD group_preference_id INT DEFAULT NULL, DROP group_preference');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0987F9EC82 FOREIGN KEY (group_preference_id) REFERENCES group_type (id)');
        $this->addSql('CREATE INDEX IDX_81398E0987F9EC82 ON customer (group_preference_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE boupload');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E0987F9EC82');
        $this->addSql('DROP INDEX IDX_81398E0987F9EC82 ON customer');
        $this->addSql('ALTER TABLE customer ADD group_preference VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP group_preference_id');
    }
}
