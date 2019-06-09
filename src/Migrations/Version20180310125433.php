<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180310125433 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, program_group_id INT DEFAULT NULL, location_id INT DEFAULT NULL, program_type_id INT DEFAULT NULL, days INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_92ED7784CDEADB2A (agency_id), INDEX IDX_92ED77847F612572 (program_group_id), INDEX IDX_92ED778464D218E (location_id), INDEX IDX_92ED77844EA67447 (program_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED77847F612572 FOREIGN KEY (program_group_id) REFERENCES program_group (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778464D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED77844EA67447 FOREIGN KEY (program_type_id) REFERENCES program_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE program');
    }
}
