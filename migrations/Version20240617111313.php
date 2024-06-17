<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617111313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556970926F');
        $this->addSql('DROP INDEX IDX_42C849556970926F ON reservation');
        $this->addSql('ALTER TABLE reservation ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP id_profile_id, CHANGE nom id_profile VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD id_profile_id INT NOT NULL, DROP created_at, CHANGE id_profile nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556970926F FOREIGN KEY (id_profile_id) REFERENCES profile (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_42C849556970926F ON reservation (id_profile_id)');
    }
}
