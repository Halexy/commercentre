<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216084547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create relation between user and user merchant';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_merchant ADD CONSTRAINT FK_9426C1E1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9426C1E1A76ED395 ON user_merchant (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_merchant DROP FOREIGN KEY FK_9426C1E1A76ED395');
        $this->addSql('DROP INDEX UNIQ_9426C1E1A76ED395 ON user_merchant');
        $this->addSql('ALTER TABLE user_merchant DROP user_id');
    }
}
