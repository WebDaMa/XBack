<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180310122223 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, activity_group_id INT DEFAULT NULL, location_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AC74095ACDEADB2A (agency_id), INDEX IDX_AC74095A5E5E6949 (activity_group_id), INDEX IDX_AC74095A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095ACDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A5E5E6949 FOREIGN KEY (activity_group_id) REFERENCES activity_group (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activity');
    }
}
