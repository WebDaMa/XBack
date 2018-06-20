<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180620194548 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF681C06096');
        $this->addSql('DROP INDEX IDX_D499BFF681C06096 ON planning');
        $this->addSql('ALTER TABLE planning CHANGE activity_id planning_activity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6CCEBA0CF FOREIGN KEY (planning_activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6CCEBA0CF ON planning (planning_activity_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6CCEBA0CF');
        $this->addSql('DROP INDEX IDX_D499BFF6CCEBA0CF ON planning');
        $this->addSql('ALTER TABLE planning CHANGE planning_activity_id activity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF681C06096 ON planning (activity_id)');
    }
}
