<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112175016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_category (id INT AUTO_INCREMENT NOT NULL, parent_id_id INT DEFAULT NULL, category_name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_B9A19060B3750AF4 (parent_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A19060B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES post_category (id)');
        $this->addSql('ALTER TABLE post ADD post_category_id INT DEFAULT NULL, CHANGE post_type post_type ENUM(\'post\', \'page\'), CHANGE post_status post_status ENUM(\'draft\', \'pending\', \'active\', \'inactive\', \'trashed\')');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFE0617CD FOREIGN KEY (post_category_id) REFERENCES post_category (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DFE0617CD ON post (post_category_id)');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'male\', \'female\', \'other\'), CHANGE status status ENUM(\'pending\', \'active\', \'inactive\', \'trashed\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFE0617CD');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A19060B3750AF4');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP INDEX IDX_5A8A6C8DFE0617CD ON post');
        $this->addSql('ALTER TABLE post DROP post_category_id, CHANGE post_type post_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_status post_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
