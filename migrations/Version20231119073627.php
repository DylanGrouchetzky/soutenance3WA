<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119073627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tome_user_read (id INT AUTO_INCREMENT NOT NULL, name_tome_id INT DEFAULT NULL, user_id INT DEFAULT NULL, collection_library_id INT DEFAULT NULL, INDEX IDX_D045D9AB80D87B98 (name_tome_id), INDEX IDX_D045D9ABA76ED395 (user_id), INDEX IDX_D045D9AB5DBF6913 (collection_library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tome_user_read ADD CONSTRAINT FK_D045D9AB80D87B98 FOREIGN KEY (name_tome_id) REFERENCES tome_collection (id)');
        $this->addSql('ALTER TABLE tome_user_read ADD CONSTRAINT FK_D045D9ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tome_user_read ADD CONSTRAINT FK_D045D9AB5DBF6913 FOREIGN KEY (collection_library_id) REFERENCES collection_library (id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tome_user_read DROP FOREIGN KEY FK_D045D9AB80D87B98');
        $this->addSql('ALTER TABLE tome_user_read DROP FOREIGN KEY FK_D045D9ABA76ED395');
        $this->addSql('ALTER TABLE tome_user_read DROP FOREIGN KEY FK_D045D9AB5DBF6913');
        $this->addSql('DROP TABLE tome_user_read');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
