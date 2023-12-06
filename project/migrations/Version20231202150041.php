<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202150041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, category_name VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, shortdesc LONGTEXT NOT NULL, price NUMERIC(10, 4) NOT NULL, link VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, rating INT NOT NULL, caffeine_type VARCHAR(255) NOT NULL, count INT NOT NULL, flavored VARCHAR(255) NOT NULL, seasonal VARCHAR(255) NOT NULL, instock VARCHAR(255) NOT NULL, facebook INT NOT NULL, is_kcup TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
    }
}
