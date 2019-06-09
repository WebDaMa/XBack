<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180705145347 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE export_raft (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, date DATE DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_EB1959F3B03A8386 (created_by_id), INDEX IDX_EB1959F3896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE export_raft ADD CONSTRAINT FK_EB1959F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE export_raft ADD CONSTRAINT FK_EB1959F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE payment ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DB03A8386 ON payment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D896DBBDE ON payment (updated_by_id)');
        $this->addSql('ALTER TABLE customer ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_81398E09B03A8386 ON customer (created_by_id)');
        $this->addSql('CREATE INDEX IDX_81398E09896DBBDE ON customer (updated_by_id)');
        $this->addSql('ALTER TABLE groep ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groep ADD CONSTRAINT FK_27025694B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE groep ADD CONSTRAINT FK_27025694896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_27025694B03A8386 ON groep (created_by_id)');
        $this->addSql('CREATE INDEX IDX_27025694896DBBDE ON groep (updated_by_id)');
        $this->addSql('ALTER TABLE upload ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FB03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_17BDE61FB03A8386 ON upload (created_by_id)');
        $this->addSql('CREATE INDEX IDX_17BDE61F896DBBDE ON upload (updated_by_id)');
        $this->addSql('ALTER TABLE planning ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6B03A8386 ON planning (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6896DBBDE ON planning (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE export_raft');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09B03A8386');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09896DBBDE');
        $this->addSql('DROP INDEX IDX_81398E09B03A8386 ON customer');
        $this->addSql('DROP INDEX IDX_81398E09896DBBDE ON customer');
        $this->addSql('ALTER TABLE customer DROP created_by_id, DROP updated_by_id');
        $this->addSql('ALTER TABLE groep DROP FOREIGN KEY FK_27025694B03A8386');
        $this->addSql('ALTER TABLE groep DROP FOREIGN KEY FK_27025694896DBBDE');
        $this->addSql('DROP INDEX IDX_27025694B03A8386 ON groep');
        $this->addSql('DROP INDEX IDX_27025694896DBBDE ON groep');
        $this->addSql('ALTER TABLE groep DROP created_by_id, DROP updated_by_id');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DB03A8386');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D896DBBDE');
        $this->addSql('DROP INDEX IDX_6D28840DB03A8386 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D896DBBDE ON payment');
        $this->addSql('ALTER TABLE payment DROP created_by_id, DROP updated_by_id');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6B03A8386');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6896DBBDE');
        $this->addSql('DROP INDEX IDX_D499BFF6B03A8386 ON planning');
        $this->addSql('DROP INDEX IDX_D499BFF6896DBBDE ON planning');
        $this->addSql('ALTER TABLE planning DROP created_by_id, DROP updated_by_id');
        $this->addSql('ALTER TABLE upload DROP FOREIGN KEY FK_17BDE61FB03A8386');
        $this->addSql('ALTER TABLE upload DROP FOREIGN KEY FK_17BDE61F896DBBDE');
        $this->addSql('DROP INDEX IDX_17BDE61FB03A8386 ON upload');
        $this->addSql('DROP INDEX IDX_17BDE61F896DBBDE ON upload');
        $this->addSql('ALTER TABLE upload DROP created_by_id, DROP updated_by_id');
    }
}
