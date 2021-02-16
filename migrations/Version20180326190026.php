<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180326190026 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groep ADD location_id INT DEFAULT NULL, DROP location');
        $this->addSql('ALTER TABLE groep ADD CONSTRAINT FK_2702569464D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_2702569464D218E ON groep (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groep DROP FOREIGN KEY FK_2702569464D218E');
        $this->addSql('DROP INDEX IDX_2702569464D218E ON groep');
        $this->addSql('ALTER TABLE groep ADD location VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP location_id');
    }
}
