<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203101251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commune CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE personne ADD photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prefecture CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE type_camp CHANGE code code VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commune CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE personne DROP photo');
        $this->addSql('ALTER TABLE prefecture CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE type_camp CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
