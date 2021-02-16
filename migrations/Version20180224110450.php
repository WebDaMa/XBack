<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224110450 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, group_id INT NOT NULL, name VARCHAR(255) NOT NULL, period_id INT NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guide (id INT AUTO_INCREMENT NOT NULL, guide_short VARCHAR(255) NOT NULL, guide_first_name VARCHAR(255) NOT NULL, guide_last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, guide_id INT DEFAULT NULL, planning_id INT NOT NULL, date DATE NOT NULL, activity VARCHAR(255) NOT NULL, guide_function INT NOT NULL, INDEX IDX_D499BFF6FE54D947 (group_id), INDEX IDX_D499BFF6D7ED1D4B (guide_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6D7ED1D4B FOREIGN KEY (guide_id) REFERENCES guide (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6FE54D947');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6D7ED1D4B');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE guide');
        $this->addSql('DROP TABLE planning');
    }
}
