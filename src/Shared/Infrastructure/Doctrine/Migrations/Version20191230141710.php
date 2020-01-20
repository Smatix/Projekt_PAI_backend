<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191230141710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id VARCHAR(36) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parkingopening_hours (id INT AUTO_INCREMENT NOT NULL, parking_id VARCHAR(36) DEFAULT NULL, week_day INT NOT NULL, open TIME NOT NULL, close TIME NOT NULL, INDEX IDX_FDF91AA1F17B2DD (parking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking_space (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, parking_id VARCHAR(36) DEFAULT NULL, count INT NOT NULL, INDEX IDX_E00675CCC54C8C93 (type_id), INDEX IDX_E00675CCF17B2DD (parking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_list (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, parking_id VARCHAR(36) DEFAULT NULL, period INT NOT NULL, unit VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, INDEX IDX_399A0AA2C54C8C93 (type_id), INDEX IDX_399A0AA2F17B2DD (parking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_list (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, parking_id VARCHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, period INT NOT NULL, unit VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, INDEX IDX_73F4E806C54C8C93 (type_id), INDEX IDX_73F4E806F17B2DD (parking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking (id VARCHAR(36) NOT NULL, owner VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, coordinate_latitude VARCHAR(255) DEFAULT NULL, coordinate_longitude VARCHAR(255) DEFAULT NULL, address_street VARCHAR(255) NOT NULL, address_number VARCHAR(255) NOT NULL, address_post_code VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking_space_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parkingopening_hours ADD CONSTRAINT FK_FDF91AA1F17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id)');
        $this->addSql('ALTER TABLE parking_space ADD CONSTRAINT FK_E00675CCC54C8C93 FOREIGN KEY (type_id) REFERENCES parking_space_type (id)');
        $this->addSql('ALTER TABLE parking_space ADD CONSTRAINT FK_E00675CCF17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id)');
        $this->addSql('ALTER TABLE price_list ADD CONSTRAINT FK_399A0AA2C54C8C93 FOREIGN KEY (type_id) REFERENCES parking_space_type (id)');
        $this->addSql('ALTER TABLE price_list ADD CONSTRAINT FK_399A0AA2F17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id)');
        $this->addSql('ALTER TABLE subscription_list ADD CONSTRAINT FK_73F4E806C54C8C93 FOREIGN KEY (type_id) REFERENCES parking_space_type (id)');
        $this->addSql('ALTER TABLE subscription_list ADD CONSTRAINT FK_73F4E806F17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parkingopening_hours DROP FOREIGN KEY FK_FDF91AA1F17B2DD');
        $this->addSql('ALTER TABLE parking_space DROP FOREIGN KEY FK_E00675CCF17B2DD');
        $this->addSql('ALTER TABLE price_list DROP FOREIGN KEY FK_399A0AA2F17B2DD');
        $this->addSql('ALTER TABLE subscription_list DROP FOREIGN KEY FK_73F4E806F17B2DD');
        $this->addSql('ALTER TABLE parking_space DROP FOREIGN KEY FK_E00675CCC54C8C93');
        $this->addSql('ALTER TABLE price_list DROP FOREIGN KEY FK_399A0AA2C54C8C93');
        $this->addSql('ALTER TABLE subscription_list DROP FOREIGN KEY FK_73F4E806C54C8C93');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE parkingopening_hours');
        $this->addSql('DROP TABLE parking_space');
        $this->addSql('DROP TABLE price_list');
        $this->addSql('DROP TABLE subscription_list');
        $this->addSql('DROP TABLE parking');
        $this->addSql('DROP TABLE parking_space_type');
    }
}
