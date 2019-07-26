<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190726112233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, started_at DATETIME NOT NULL, ended_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, first_name VARCHAR(100) DEFAULT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(10) DEFAULT NULL, city VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, total_single_rooms SMALLINT NOT NULL, total_double_rooms SMALLINT NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, website VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, capacity SMALLINT NOT NULL, price SMALLINT NOT NULL, floor SMALLINT NOT NULL, INDEX IDX_729F519B3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B3243BB18');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE room');
    }
}
