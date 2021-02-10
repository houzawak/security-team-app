<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202154202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE camp (code INT AUTO_INCREMENT NOT NULL, code_ville INT DEFAULT NULL, code_type_camp VARCHAR(30) DEFAULT NULL, libelle VARCHAR(150) NOT NULL, INDEX IDX_C1944230AF96C08F (code_ville), INDEX IDX_C1944230BADEFF00 (code_type_camp), PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, code_ville INT DEFAULT NULL, code_camp INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, internal_status SMALLINT DEFAULT 1 NOT NULL COMMENT \'Status interne de l\'\'entité\', nom VARCHAR(150) NOT NULL, prenoms VARCHAR(150) NOT NULL, poste VARCHAR(50) DEFAULT NULL, grade VARCHAR(50) DEFAULT NULL, lieu_affectation VARCHAR(150) DEFAULT NULL, INDEX IDX_FCEC9EFAF96C08F (code_ville), INDEX IDX_FCEC9EFF77F28F1 (code_camp), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE camp ADD CONSTRAINT FK_C1944230AF96C08F FOREIGN KEY (code_ville) REFERENCES ville (code)');
        $this->addSql('ALTER TABLE camp ADD CONSTRAINT FK_C1944230BADEFF00 FOREIGN KEY (code_type_camp) REFERENCES type_camp (code)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFAF96C08F FOREIGN KEY (code_ville) REFERENCES ville (code)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFF77F28F1 FOREIGN KEY (code_camp) REFERENCES camp (code)');
        $this->addSql('ALTER TABLE commune CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE prefecture CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE type_camp CHANGE code code VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFF77F28F1');
        $this->addSql('DROP TABLE camp');
        $this->addSql('DROP TABLE personne');
        $this->addSql('ALTER TABLE commune CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE prefecture CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE type_camp CHANGE code code VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
