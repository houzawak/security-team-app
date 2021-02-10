<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209112101 extends AbstractMigration
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
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFAF96C08F');
        $this->addSql('DROP INDEX IDX_FCEC9EFAF96C08F ON personne');
        $this->addSql('ALTER TABLE personne DROP lieu_affectation, CHANGE code_ville position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prefecture CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE type_camp CHANGE code code VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commune CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE personne ADD lieu_affectation VARCHAR(150) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE position code_ville INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFAF96C08F FOREIGN KEY (code_ville) REFERENCES ville (code)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFAF96C08F ON personne (code_ville)');
        $this->addSql('ALTER TABLE prefecture CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE type_camp CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
