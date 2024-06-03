<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603114309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY tarification_ibfk_1');
        $this->addSql('DROP TABLE tarification');
        $this->addSql('ALTER TABLE reservation DROP id_tarification_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tarification (id INT AUTO_INCREMENT NOT NULL, id_activite_id INT NOT NULL, prix_par_heure NUMERIC(10, 2) NOT NULL, prix_pour_5_heures NUMERIC(10, 2) NOT NULL, prix_pour_10_heures NUMERIC(10, 2) NOT NULL, INDEX id_activite_id (id_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT tarification_ibfk_1 FOREIGN KEY (id_activite_id) REFERENCES activite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservation ADD id_tarification_id INT NOT NULL');
    }
}
