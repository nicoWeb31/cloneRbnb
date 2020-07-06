<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200706121559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        
        $this->addSql('CREATE TABLE user_category_user (user_id INT NOT NULL, category_user_id INT NOT NULL, 
        INDEX IDX_E886015EA76ED395 (user_id), INDEX IDX_E886015E60B693EB (category_user_id), PRIMARY KEY(user_id, category_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_category_user ADD CONSTRAINT FK_E886015EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_category_user ADD CONSTRAINT FK_E886015E60B693EB FOREIGN KEY (category_user_id) REFERENCES category_user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_category_user DROP FOREIGN KEY FK_E886015E60B693EB');
        $this->addSql('ALTER TABLE user_category_user DROP FOREIGN KEY FK_E886015EA76ED395');
        $this->addSql('DROP TABLE category_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_category_user');
    }
}
