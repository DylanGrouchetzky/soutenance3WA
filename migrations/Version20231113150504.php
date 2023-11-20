<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113150504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_user ADD category_collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collection_user ADD CONSTRAINT FK_C7E4FAA74F9273B6 FOREIGN KEY (category_collection_id) REFERENCES category_collection (id)');
        $this->addSql('CREATE INDEX IDX_C7E4FAA74F9273B6 ON collection_user (category_collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_user DROP FOREIGN KEY FK_C7E4FAA74F9273B6');
        $this->addSql('DROP INDEX IDX_C7E4FAA74F9273B6 ON collection_user');
        $this->addSql('ALTER TABLE collection_user DROP category_collection_id');
    }
}
