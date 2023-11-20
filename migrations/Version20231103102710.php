<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103102710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tome_collection (id INT AUTO_INCREMENT NOT NULL, collection_library_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, date_modifie DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_8C1502695DBF6913 (collection_library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tome_collection ADD CONSTRAINT FK_8C1502695DBF6913 FOREIGN KEY (collection_library_id) REFERENCES collection_library (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tome_collection DROP FOREIGN KEY FK_8C1502695DBF6913');
        $this->addSql('DROP TABLE tome_collection');
    }
}
