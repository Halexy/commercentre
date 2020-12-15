<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215093438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Re add relation between pins and user';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pins ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE pins ADD CONSTRAINT FK_3F0FE980A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_3F0FE980A76ED395 ON pins (user_id)');
        $this->addSql('ALTER TABLE user_merchant CHANGE logo_name logo_name VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pins DROP FOREIGN KEY FK_3F0FE980A76ED395');
        $this->addSql('DROP INDEX IDX_3F0FE980A76ED395 ON pins');
        $this->addSql('ALTER TABLE pins ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_merchant CHANGE logo_name logo_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
