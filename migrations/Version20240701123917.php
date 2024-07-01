<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701123917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, detail LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_discipline_id INT NOT NULL, id_profile_id INT NOT NULL, contenu LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_67F068BC1B7AF664 (id_discipline_id), INDEX IDX_67F068BC6970926F (id_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, id_activite_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, detail LONGTEXT NOT NULL, INDEX IDX_75BEEE3F831D4546 (id_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facturation (id INT AUTO_INCREMENT NOT NULL, id_reservation_id INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_17EB513A85542AE1 (id_reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', amount NUMERIC(10, 2) NOT NULL, INDEX IDX_90651744F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, id_profile_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_paid TINYINT(1) NOT NULL, stripe_session_id VARCHAR(255) DEFAULT NULL, INDEX IDX_24CC0DF26970926F (id_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_discipline (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, discipline_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_116BD7AAF77D927C (panier_id), INDEX IDX_116BD7AAA5522701 (discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, id_reservation_id INT NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_D79F6B1185542AE1 (id_reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, status VARCHAR(50) NOT NULL, nom_entreprise VARCHAR(100) DEFAULT NULL, siret VARCHAR(30) DEFAULT NULL, domiciliation VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, sexe VARCHAR(255) NOT NULL, bio VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8157AA0F79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_profile_id INT NOT NULL, id_discipline_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', book_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_42C849556970926F (id_profile_id), INDEX IDX_42C849551B7AF664 (id_discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, url VARCHAR(255) NOT NULL, durer TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC1B7AF664 FOREIGN KEY (id_discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6970926F FOREIGN KEY (id_profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F831D4546 FOREIGN KEY (id_activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT FK_17EB513A85542AE1 FOREIGN KEY (id_reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF26970926F FOREIGN KEY (id_profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE panier_discipline ADD CONSTRAINT FK_116BD7AAF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier_discipline ADD CONSTRAINT FK_116BD7AAA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1185542AE1 FOREIGN KEY (id_reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556970926F FOREIGN KEY (id_profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551B7AF664 FOREIGN KEY (id_discipline_id) REFERENCES discipline (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC1B7AF664');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6970926F');
        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F831D4546');
        $this->addSql('ALTER TABLE facturation DROP FOREIGN KEY FK_17EB513A85542AE1');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744F77D927C');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF26970926F');
        $this->addSql('ALTER TABLE panier_discipline DROP FOREIGN KEY FK_116BD7AAF77D927C');
        $this->addSql('ALTER TABLE panier_discipline DROP FOREIGN KEY FK_116BD7AAA5522701');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1185542AE1');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F79F37AE5');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556970926F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551B7AF664');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE facturation');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_discipline');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
