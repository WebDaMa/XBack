<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180620195917 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6D7ED1D4B');
        $this->addSql('DROP INDEX IDX_D499BFF6D7ED1D4B ON planning');
        $this->addSql('ALTER TABLE planning CHANGE guide_id planning_guide_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6E0E84BE6 FOREIGN KEY (planning_guide_id) REFERENCES guide (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6E0E84BE6 ON planning (planning_guide_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6E0E84BE6');
        $this->addSql('DROP INDEX IDX_D499BFF6E0E84BE6 ON planning');
        $this->addSql('ALTER TABLE planning CHANGE planning_guide_id guide_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6D7ED1D4B FOREIGN KEY (guide_id) REFERENCES guide (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6D7ED1D4B ON planning (guide_id)');
    }
}
