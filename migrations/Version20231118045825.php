<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231118045825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_tome (id INT AUTO_INCREMENT NOT NULL, collection_library_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_4243BF875DBF6913 (collection_library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_tome ADD CONSTRAINT FK_4243BF875DBF6913 FOREIGN KEY (collection_library_id) REFERENCES collection_library (id)');
        $this->addSql('ALTER TABLE tome_collection ADD group_tome_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tome_collection ADD CONSTRAINT FK_8C150269EB36A2A FOREIGN KEY (group_tome_id) REFERENCES group_tome (id)');
        $this->addSql('CREATE INDEX IDX_8C150269EB36A2A ON tome_collection (group_tome_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tome_collection DROP FOREIGN KEY FK_8C150269EB36A2A');
        $this->addSql('ALTER TABLE group_tome DROP FOREIGN KEY FK_4243BF875DBF6913');
        $this->addSql('DROP TABLE group_tome');
        $this->addSql('DROP INDEX IDX_8C150269EB36A2A ON tome_collection');
        $this->addSql('ALTER TABLE tome_collection DROP group_tome_id');
    }
}
