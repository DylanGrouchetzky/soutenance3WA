<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102101020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_collection (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, date_modifie DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_library (id INT AUTO_INCREMENT NOT NULL, category_collection_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, number_tome INT NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_F5ACEA6D4F9273B6 (category_collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collection_library_genre_collection (collection_library_id INT NOT NULL, genre_collection_id INT NOT NULL, INDEX IDX_B7B9E7EB5DBF6913 (collection_library_id), INDEX IDX_B7B9E7EBCC97DC31 (genre_collection_id), PRIMARY KEY(collection_library_id, genre_collection_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_collection (id INT AUTO_INCREMENT NOT NULL, category_collection_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, date_modifie DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_8024E9174F9273B6 (category_collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collection_library ADD CONSTRAINT FK_F5ACEA6D4F9273B6 FOREIGN KEY (category_collection_id) REFERENCES category_collection (id)');
        $this->addSql('ALTER TABLE collection_library_genre_collection ADD CONSTRAINT FK_B7B9E7EB5DBF6913 FOREIGN KEY (collection_library_id) REFERENCES collection_library (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collection_library_genre_collection ADD CONSTRAINT FK_B7B9E7EBCC97DC31 FOREIGN KEY (genre_collection_id) REFERENCES genre_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_collection ADD CONSTRAINT FK_8024E9174F9273B6 FOREIGN KEY (category_collection_id) REFERENCES category_collection (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_library DROP FOREIGN KEY FK_F5ACEA6D4F9273B6');
        $this->addSql('ALTER TABLE collection_library_genre_collection DROP FOREIGN KEY FK_B7B9E7EB5DBF6913');
        $this->addSql('ALTER TABLE collection_library_genre_collection DROP FOREIGN KEY FK_B7B9E7EBCC97DC31');
        $this->addSql('ALTER TABLE genre_collection DROP FOREIGN KEY FK_8024E9174F9273B6');
        $this->addSql('DROP TABLE category_collection');
        $this->addSql('DROP TABLE collection_library');
        $this->addSql('DROP TABLE collection_library_genre_collection');
        $this->addSql('DROP TABLE genre_collection');
    }
}
