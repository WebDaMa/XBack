<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180603130652 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program_activity DROP FOREIGN KEY FK_2D41F56F3EB8070A');
        $this->addSql('DROP INDEX IDX_2D41F56F3EB8070A ON program_activity');
        $this->addSql('ALTER TABLE program_activity CHANGE program_id program_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_activity ADD CONSTRAINT FK_2D41F56F4EA67447 FOREIGN KEY (program_type_id) REFERENCES program_type (id)');
        $this->addSql('CREATE INDEX IDX_2D41F56F4EA67447 ON program_activity (program_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program_activity DROP FOREIGN KEY FK_2D41F56F4EA67447');
        $this->addSql('DROP INDEX IDX_2D41F56F4EA67447 ON program_activity');
        $this->addSql('ALTER TABLE program_activity CHANGE program_type_id program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_activity ADD CONSTRAINT FK_2D41F56F3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_2D41F56F3EB8070A ON program_activity (program_id)');
    }
}
