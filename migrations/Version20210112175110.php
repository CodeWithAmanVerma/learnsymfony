<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112175110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post CHANGE post_type post_type ENUM(\'post\', \'page\'), CHANGE post_status post_status ENUM(\'draft\', \'pending\', \'active\', \'inactive\', \'trashed\')');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A19060B3750AF4');
        $this->addSql('DROP INDEX IDX_B9A19060B3750AF4 ON post_category');
        $this->addSql('ALTER TABLE post_category CHANGE parent_id_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A19060727ACA70 FOREIGN KEY (parent_id) REFERENCES post_category (id)');
        $this->addSql('CREATE INDEX IDX_B9A19060727ACA70 ON post_category (parent_id)');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'male\', \'female\', \'other\'), CHANGE status status ENUM(\'pending\', \'active\', \'inactive\', \'trashed\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post CHANGE post_type post_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_status post_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A19060727ACA70');
        $this->addSql('DROP INDEX IDX_B9A19060727ACA70 ON post_category');
        $this->addSql('ALTER TABLE post_category CHANGE parent_id parent_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A19060B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES post_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B9A19060B3750AF4 ON post_category (parent_id_id)');
        $this->addSql('ALTER TABLE `user` CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
