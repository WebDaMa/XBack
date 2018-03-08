<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180308175831 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE travel_type ADD transport_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE travel_type ADD CONSTRAINT FK_4786B484519B4C62 FOREIGN KEY (transport_type_id) REFERENCES transport_type (id)');
        $this->addSql('CREATE INDEX IDX_4786B484519B4C62 ON travel_type (transport_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE travel_type DROP FOREIGN KEY FK_4786B484519B4C62');
        $this->addSql('DROP INDEX IDX_4786B484519B4C62 ON travel_type');
        $this->addSql('ALTER TABLE travel_type DROP transport_type_id');
    }
}
