<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224114226 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer CHANGE booker_payed booker_payed TINYINT(1) DEFAULT NULL, CHANGE is_camper is_camper TINYINT(1) DEFAULT NULL, CHANGE checked_in checked_in TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD print TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer CHANGE booker_payed booker_payed SMALLINT DEFAULT NULL, CHANGE is_camper is_camper SMALLINT DEFAULT NULL, CHANGE checked_in checked_in SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning DROP print');
    }
}
