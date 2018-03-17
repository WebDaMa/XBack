<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180317123722 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_6D28840D9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE groep ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE upload ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE planning ADD activity_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL, DROP activity');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF681C06096 ON planning (activity_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE payment');
        $this->addSql('ALTER TABLE customer DROP created_at, DROP modified_at');
        $this->addSql('ALTER TABLE groep DROP created_at, DROP modified_at');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF681C06096');
        $this->addSql('DROP INDEX IDX_D499BFF681C06096 ON planning');
        $this->addSql('ALTER TABLE planning ADD activity VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP activity_id, DROP created_at, DROP modified_at');
        $this->addSql('ALTER TABLE upload DROP created_at, DROP modified_at');
    }
}
