<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113222840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fitnessp (marque VARCHAR(10) NOT NULL, PRIMARY KEY(marque)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fitnessp_admin (mail VARCHAR(100) NOT NULL, marque VARCHAR(10) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, niveau_droits SMALLINT NOT NULL, PRIMARY KEY(mail)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fitnessp_partenaire (mail VARCHAR(100) NOT NULL, marque VARCHAR(10) NOT NULL, nom VARCHAR(100) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, niveau_droits SMALLINT NOT NULL, premiere_connexion SMALLINT NOT NULL, nombre_de_structures SMALLINT NOT NULL, perm_boissons SMALLINT DEFAULT NULL, perm_planning SMALLINT DEFAULT NULL, perm_newsletter SMALLINT DEFAULT NULL, UNIQUE INDEX UNIQ_C31F04C26C6E55B5 (nom), PRIMARY KEY(mail)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fitnessp_structure (mail VARCHAR(100) NOT NULL, mail_partenaire VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, niveau_droits SMALLINT NOT NULL, premiere_connexion SMALLINT NOT NULL, perm_boissons SMALLINT DEFAULT NULL, perm_planning SMALLINT DEFAULT NULL, perm_newsletter SMALLINT DEFAULT NULL, UNIQUE INDEX UNIQ_5B44C43BC35F0816 (adresse), PRIMARY KEY(mail)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fitnessp');
        $this->addSql('DROP TABLE fitnessp_admin');
        $this->addSql('DROP TABLE fitnessp_partenaire');
        $this->addSql('DROP TABLE fitnessp_structure');
        $this->addSql('DROP TABLE user');
    }
}
