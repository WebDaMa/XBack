<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171230143635 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer ADD customer_id INT NOT NULL, ADD file_id INT NOT NULL, ADD period_id INT NOT NULL, ADD booker_id INT NOT NULL, ADD type_person VARCHAR(255) DEFAULT NULL, ADD info_customer LONGTEXT DEFAULT NULL, ADD info_file LONGTEXT DEFAULT NULL, ADD agency VARCHAR(255) NOT NULL, ADD location VARCHAR(255) NOT NULL, ADD start_day DATE NOT NULL, ADD end_day DATE NOT NULL, ADD program_type VARCHAR(255) NOT NULL, ADD lodging_type VARCHAR(255) NOT NULL, ADD all_in_type VARCHAR(255) NOT NULL, ADD insurance_type VARCHAR(255) NOT NULL, ADD travel_go_type VARCHAR(255) NOT NULL, ADD travel_go_date DATE DEFAULT NULL, ADD travel_back_type VARCHAR(255) NOT NULL, ADD travel_back_date DATE DEFAULT NULL, ADD boarding_point VARCHAR(255) DEFAULT NULL, ADD activity_option VARCHAR(255) DEFAULT NULL, ADD group_name VARCHAR(255) DEFAULT NULL, ADD group_preference VARCHAR(255) DEFAULT NULL, ADD lodging_layout VARCHAR(255) DEFAULT NULL, ADD group_layout VARCHAR(255) DEFAULT NULL, ADD booker_payed SMALLINT DEFAULT NULL, ADD payer_id VARCHAR(255) DEFAULT NULL, ADD is_camper SMALLINT DEFAULT NULL, ADD checked_in SMALLINT DEFAULT NULL, ADD total_excl_insurance INT DEFAULT NULL, ADD insurance_value INT DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE birthdate birthdate DATE DEFAULT NULL, CHANGE gsm gsm VARCHAR(255) DEFAULT NULL, CHANGE national_register_number national_register_number VARCHAR(255) DEFAULT NULL, CHANGE expire_date expire_date DATE DEFAULT NULL, CHANGE size size VARCHAR(255) DEFAULT NULL, CHANGE name_shortage name_shortage VARCHAR(255) DEFAULT NULL, CHANGE emergency_number emergency_number VARCHAR(255) DEFAULT NULL, CHANGE license_plate license_plate VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP customer_id, DROP file_id, DROP period_id, DROP booker_id, DROP type_person, DROP info_customer, DROP info_file, DROP agency, DROP location, DROP start_day, DROP end_day, DROP program_type, DROP lodging_type, DROP all_in_type, DROP insurance_type, DROP travel_go_type, DROP travel_go_date, DROP travel_back_type, DROP travel_back_date, DROP boarding_point, DROP activity_option, DROP group_name, DROP group_preference, DROP lodging_layout, DROP group_layout, DROP booker_payed, DROP payer_id, DROP is_camper, DROP checked_in, DROP total_excl_insurance, DROP insurance_value, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE birthdate birthdate DATE NOT NULL, CHANGE gsm gsm VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE national_register_number national_register_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE expire_date expire_date DATE NOT NULL, CHANGE size size VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE name_shortage name_shortage VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE emergency_number emergency_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE license_plate license_plate VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
