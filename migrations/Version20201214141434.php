<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214141434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create user merchant table and verify if the user is merchant or not';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_merchant (id INT AUTO_INCREMENT NOT NULL, brand_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, siret_number VARCHAR(255) NOT NULL, logo_name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, category VARCHAR(255) DEFAULT NULL, addess_line VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users ADD is_merchant TINYINT(1) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD zip_code VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_merchant');
        $this->addSql('ALTER TABLE users DROP is_merchant, DROP city, DROP zip_code');
    }
}
