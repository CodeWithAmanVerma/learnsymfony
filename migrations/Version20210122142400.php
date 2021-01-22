<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122142400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, icon VARCHAR(20) DEFAULT NULL, type ENUM(\'linktoDashboard\', \'linkToCrud\', \'linkToRoute\', \'section\'), entity_path VARCHAR(100) DEFAULT NULL, status TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, role VARCHAR(20) DEFAULT NULL, INDEX IDX_7D053A93727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, post_author_id INT DEFAULT NULL, post_category_id INT DEFAULT NULL, post_title VARCHAR(255) NOT NULL, post_slug VARCHAR(255) NOT NULL, post_content LONGTEXT NOT NULL, post_type ENUM(\'post\', \'page\'), post_status ENUM(\'draft\', \'pending\', \'active\', \'inactive\', \'trashed\'), post_thumbnail VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_5A8A6C8D571B8DEC (post_author_id), INDEX IDX_5A8A6C8DFE0617CD (post_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, category_name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_B9A19060727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, mobile VARCHAR(20) NOT NULL, dob DATE DEFAULT NULL, gender ENUM(\'male\', \'female\', \'other\'), status ENUM(\'pending\', \'active\', \'inactive\', \'trashed\'), created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93727ACA70 FOREIGN KEY (parent_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D571B8DEC FOREIGN KEY (post_author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFE0617CD FOREIGN KEY (post_category_id) REFERENCES post_category (id)');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A19060727ACA70 FOREIGN KEY (parent_id) REFERENCES post_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93727ACA70');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFE0617CD');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A19060727ACA70');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D571B8DEC');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE `user`');
    }
}
