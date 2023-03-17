<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317001956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, brand_name_id INT NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, rights SMALLINT NOT NULL, INDEX IDX_880E0D76962C39AD (brand_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, brand_name_id INT NOT NULL, mail VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, rights SMALLINT NOT NULL, drinks_permission SMALLINT DEFAULT NULL, newsletter_permission SMALLINT DEFAULT NULL, planning_permission SMALLINT DEFAULT NULL, INDEX IDX_312B3E16962C39AD (brand_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, brand_name_id INT NOT NULL, city_id INT NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, rights SMALLINT NOT NULL, drinks_permission SMALLINT DEFAULT NULL, newsletter_permission SMALLINT DEFAULT NULL, planning_permission SMALLINT DEFAULT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_6F0137EA962C39AD (brand_name_id), INDEX IDX_6F0137EA8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76962C39AD FOREIGN KEY (brand_name_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16962C39AD FOREIGN KEY (brand_name_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA962C39AD FOREIGN KEY (brand_name_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA8BAC62AF FOREIGN KEY (city_id) REFERENCES partner (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76962C39AD');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16962C39AD');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA962C39AD');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA8BAC62AF');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE user');
    }
}
