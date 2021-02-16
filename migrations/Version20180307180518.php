<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180307180518 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transport_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE all_in_type ADD prize DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE travel_type ADD start_point VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE insurance_type ADD insurance_code INT NOT NULL, ADD insurance_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE transport_type');
        $this->addSql('ALTER TABLE all_in_type DROP prize');
        $this->addSql('ALTER TABLE insurance_type DROP insurance_code, DROP insurance_name');
        $this->addSql('ALTER TABLE travel_type DROP start_point');
    }
}
