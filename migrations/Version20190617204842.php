<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190617204842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE export_bill ADD location_id INT DEFAULT NULL, ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD period INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL, DROP date');
        $this->addSql('ALTER TABLE export_bill ADD CONSTRAINT FK_5C902F0864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE export_bill ADD CONSTRAINT FK_5C902F08B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE export_bill ADD CONSTRAINT FK_5C902F08896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_5C902F0864D218E ON export_bill (location_id)');
        $this->addSql('CREATE INDEX IDX_5C902F08B03A8386 ON export_bill (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5C902F08896DBBDE ON export_bill (updated_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE export_bill DROP FOREIGN KEY FK_5C902F0864D218E');
        $this->addSql('ALTER TABLE export_bill DROP FOREIGN KEY FK_5C902F08B03A8386');
        $this->addSql('ALTER TABLE export_bill DROP FOREIGN KEY FK_5C902F08896DBBDE');
        $this->addSql('DROP INDEX IDX_5C902F0864D218E ON export_bill');
        $this->addSql('DROP INDEX IDX_5C902F08B03A8386 ON export_bill');
        $this->addSql('DROP INDEX IDX_5C902F08896DBBDE ON export_bill');
        $this->addSql('ALTER TABLE export_bill ADD date DATE DEFAULT NULL, DROP location_id, DROP created_by_id, DROP updated_by_id, DROP period, DROP created_at, DROP modified_at');
    }
}
