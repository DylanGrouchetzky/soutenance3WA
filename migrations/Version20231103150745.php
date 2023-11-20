<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103150745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collection_user (id INT AUTO_INCREMENT NOT NULL, collection_library_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_C7E4FAA75DBF6913 (collection_library_id), INDEX IDX_C7E4FAA7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tome_user (id INT AUTO_INCREMENT NOT NULL, name_tome_id INT DEFAULT NULL, user_id INT DEFAULT NULL, collection_library_id INT DEFAULT NULL, INDEX IDX_E641D6E380D87B98 (name_tome_id), INDEX IDX_E641D6E3A76ED395 (user_id), INDEX IDX_E641D6E35DBF6913 (collection_library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collection_user ADD CONSTRAINT FK_C7E4FAA75DBF6913 FOREIGN KEY (collection_library_id) REFERENCES collection_library (id)');
        $this->addSql('ALTER TABLE collection_user ADD CONSTRAINT FK_C7E4FAA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tome_user ADD CONSTRAINT FK_E641D6E380D87B98 FOREIGN KEY (name_tome_id) REFERENCES tome_collection (id)');
        $this->addSql('ALTER TABLE tome_user ADD CONSTRAINT FK_E641D6E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tome_user ADD CONSTRAINT FK_E641D6E35DBF6913 FOREIGN KEY (collection_library_id) REFERENCES collection_library (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_user DROP FOREIGN KEY FK_C7E4FAA75DBF6913');
        $this->addSql('ALTER TABLE collection_user DROP FOREIGN KEY FK_C7E4FAA7A76ED395');
        $this->addSql('ALTER TABLE tome_user DROP FOREIGN KEY FK_E641D6E380D87B98');
        $this->addSql('ALTER TABLE tome_user DROP FOREIGN KEY FK_E641D6E3A76ED395');
        $this->addSql('ALTER TABLE tome_user DROP FOREIGN KEY FK_E641D6E35DBF6913');
        $this->addSql('DROP TABLE collection_user');
        $this->addSql('DROP TABLE tome_user');
    }
}
