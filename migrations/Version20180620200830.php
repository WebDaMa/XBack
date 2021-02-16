<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180620200830 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6CCEBA0CF');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6E0E84BE6');
        $this->addSql('DROP INDEX IDX_D499BFF6CCEBA0CF ON planning');
        $this->addSql('DROP INDEX IDX_D499BFF6E0E84BE6 ON planning');
        $this->addSql('ALTER TABLE planning ADD activity_id INT DEFAULT NULL, ADD guide_id INT DEFAULT NULL, DROP planning_guide_id, DROP planning_activity_id');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6D7ED1D4B FOREIGN KEY (guide_id) REFERENCES guide (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF681C06096 ON planning (activity_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6D7ED1D4B ON planning (guide_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF681C06096');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6D7ED1D4B');
        $this->addSql('DROP INDEX IDX_D499BFF681C06096 ON planning');
        $this->addSql('DROP INDEX IDX_D499BFF6D7ED1D4B ON planning');
        $this->addSql('ALTER TABLE planning ADD planning_guide_id INT DEFAULT NULL, ADD planning_activity_id INT DEFAULT NULL, DROP activity_id, DROP guide_id');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6CCEBA0CF FOREIGN KEY (planning_activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6E0E84BE6 FOREIGN KEY (planning_guide_id) REFERENCES guide (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6CCEBA0CF ON planning (planning_activity_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6E0E84BE6 ON planning (planning_guide_id)');
    }
}
