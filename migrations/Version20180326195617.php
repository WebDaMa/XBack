<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180326195617 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer ADD booker_id_id INT DEFAULT NULL, DROP booker_id');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E092508AA37 FOREIGN KEY (booker_id_id) REFERENCES customer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E092508AA37 ON customer (booker_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E092508AA37');
        $this->addSql('DROP INDEX UNIQ_81398E092508AA37 ON customer');
        $this->addSql('ALTER TABLE customer ADD booker_id INT NOT NULL, DROP booker_id_id');
    }
}
