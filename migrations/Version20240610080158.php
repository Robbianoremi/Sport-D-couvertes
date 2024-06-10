<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610080158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire CHANGE date created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE profile ADD sexe VARCHAR(255) NOT NULL, ADD bio VARCHAR(255) NOT NULL, DROP image');
        $this->addSql('ALTER TABLE reservation ADD nom VARCHAR(255) NOT NULL, DROP book_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire CHANGE created_at date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE profile ADD image VARCHAR(50) NOT NULL, DROP sexe, DROP bio');
        $this->addSql('ALTER TABLE reservation ADD book_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP nom');
    }
}
