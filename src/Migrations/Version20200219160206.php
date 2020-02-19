<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219160206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento ADD title VARCHAR(255) NOT NULL, CHANGE id_creator_id id_creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE thread_id thread_id VARCHAR(255) DEFAULT NULL, CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE thread CHANGE last_comment_at last_comment_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE municipios CHANGE latitud latitud DOUBLE PRECISION DEFAULT NULL, CHANGE longitud longitud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE salt salt VARCHAR(255) DEFAULT NULL, CHANGE last_login last_login DATETIME DEFAULT NULL, CHANGE confirmation_token confirmation_token VARCHAR(180) DEFAULT NULL, CHANGE password_requested_at password_requested_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE thread_id thread_id VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evento DROP title, CHANGE id_creator_id id_creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE municipios CHANGE latitud latitud DOUBLE PRECISION DEFAULT \'NULL\', CHANGE longitud longitud DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE thread CHANGE last_comment_at last_comment_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE salt salt VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE last_login last_login DATETIME DEFAULT \'NULL\', CHANGE confirmation_token confirmation_token VARCHAR(180) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE password_requested_at password_requested_at DATETIME DEFAULT \'NULL\'');
    }
}
