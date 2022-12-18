<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215101801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fitnessp (marque VARCHAR(10) NOT NULL, PRIMARY KEY(marque))');
        $this->addSql('CREATE TABLE fitnessp_admin (mail VARCHAR(100) NOT NULL, marque VARCHAR(10) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, niveau_droits SMALLINT NOT NULL, PRIMARY KEY(mail))');
        $this->addSql('CREATE TABLE fitnessp_partenaire (mail VARCHAR(100) NOT NULL, marque VARCHAR(10) NOT NULL, nom VARCHAR(100) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, niveau_droits SMALLINT NOT NULL, premiere_connexion SMALLINT NOT NULL, nombre_de_structures SMALLINT NOT NULL, perm_boissons SMALLINT DEFAULT NULL, perm_planning SMALLINT DEFAULT NULL, perm_newsletter SMALLINT DEFAULT NULL, PRIMARY KEY(mail))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C31F04C26C6E55B5 ON fitnessp_partenaire (nom)');
        $this->addSql('CREATE TABLE fitnessp_structure (mail VARCHAR(100) NOT NULL, mail_partenaire VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, niveau_droits SMALLINT NOT NULL, premiere_connexion SMALLINT NOT NULL, perm_boissons SMALLINT DEFAULT NULL, perm_planning SMALLINT DEFAULT NULL, perm_newsletter SMALLINT DEFAULT NULL, PRIMARY KEY(mail))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5B44C43BC35F0816 ON fitnessp_structure (adresse)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
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
