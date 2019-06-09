<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180901094530 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning ADD cag1_id INT DEFAULT NULL, ADD cag2_id INT DEFAULT NULL, ADD transport VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF61E1F7D42 FOREIGN KEY (cag1_id) REFERENCES guide (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6CAAD2AC FOREIGN KEY (cag2_id) REFERENCES guide (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF61E1F7D42 ON planning (cag1_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6CAAD2AC ON planning (cag2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF61E1F7D42');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6CAAD2AC');
        $this->addSql('DROP INDEX IDX_D499BFF61E1F7D42 ON planning');
        $this->addSql('DROP INDEX IDX_D499BFF6CAAD2AC ON planning');
        $this->addSql('ALTER TABLE planning DROP cag1_id, DROP cag2_id, DROP transport');
    }
}
