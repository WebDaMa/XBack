<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180226173514 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE helm_size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suit_size (id INT AUTO_INCREMENT NOT NULL, belt_size_id INT DEFAULT NULL, helm_size_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_29CD91C7A04CEE96 (belt_size_id), INDEX IDX_29CD91C74A18F2DD (helm_size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE belt_size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE suit_size ADD CONSTRAINT FK_29CD91C7A04CEE96 FOREIGN KEY (belt_size_id) REFERENCES belt_size (id)');
        $this->addSql('ALTER TABLE suit_size ADD CONSTRAINT FK_29CD91C74A18F2DD FOREIGN KEY (helm_size_id) REFERENCES helm_size (id)');
        $this->addSql('ALTER TABLE customer ADD size_id INT DEFAULT NULL, ADD group_layout_id INT DEFAULT NULL, ADD size_info VARCHAR(255) DEFAULT NULL, DROP size, DROP group_layout');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09498DA827 FOREIGN KEY (size_id) REFERENCES suit_size (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E094C91F6FB FOREIGN KEY (group_layout_id) REFERENCES groep (id)');
        $this->addSql('CREATE INDEX IDX_81398E09498DA827 ON customer (size_id)');
        $this->addSql('CREATE INDEX IDX_81398E094C91F6FB ON customer (group_layout_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE suit_size DROP FOREIGN KEY FK_29CD91C74A18F2DD');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09498DA827');
        $this->addSql('ALTER TABLE suit_size DROP FOREIGN KEY FK_29CD91C7A04CEE96');
        $this->addSql('DROP TABLE helm_size');
        $this->addSql('DROP TABLE suit_size');
        $this->addSql('DROP TABLE belt_size');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E094C91F6FB');
        $this->addSql('DROP INDEX IDX_81398E09498DA827 ON customer');
        $this->addSql('DROP INDEX IDX_81398E094C91F6FB ON customer');
        $this->addSql('ALTER TABLE customer ADD group_layout VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP size_id, DROP group_layout_id, CHANGE size_info size VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
