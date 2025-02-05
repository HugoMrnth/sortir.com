<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203153655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant (no_participant INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles JSON NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, administrateur TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, sites_no_site INT DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (pseudo), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(no_participant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE INSCRIPTIONS DROP FOREIGN KEY inscriptions_participants_fk');
        $this->addSql('ALTER TABLE INSCRIPTIONS DROP FOREIGN KEY inscriptions_sorties_fk');
        $this->addSql('ALTER TABLE LIEUX DROP FOREIGN KEY lieux_villes_fk');
        $this->addSql('ALTER TABLE SORTIES DROP FOREIGN KEY sorties_etats_fk');
        $this->addSql('ALTER TABLE SORTIES DROP FOREIGN KEY sorties_lieux_fk');
        $this->addSql('ALTER TABLE SORTIES DROP FOREIGN KEY sorties_participants_fk');
        $this->addSql('DROP TABLE ETATS');
        $this->addSql('DROP TABLE INSCRIPTIONS');
        $this->addSql('DROP TABLE LIEUX');
        $this->addSql('DROP TABLE VILLES');
        $this->addSql('DROP TABLE SORTIES');
        $this->addSql('DROP TABLE PARTICIPANTS');
        $this->addSql('DROP TABLE SITES');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ETATS (no_etat INT NOT NULL, libelle VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(no_etat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE INSCRIPTIONS (sorties_no_sortie INT NOT NULL, participants_no_participant INT NOT NULL, date_inscription DATETIME NOT NULL, INDEX inscriptions_participants_fk (participants_no_participant), INDEX IDX_E1D2610CC731F823 (sorties_no_sortie), PRIMARY KEY(sorties_no_sortie, participants_no_participant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE LIEUX (no_lieu INT NOT NULL, villes_no_ville INT NOT NULL, nom_lieu VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, rue VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, INDEX lieux_villes_fk (villes_no_ville), PRIMARY KEY(no_lieu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE VILLES (no_ville INT NOT NULL, nom_ville VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, code_postal VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(no_ville)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE SORTIES (no_sortie INT NOT NULL, organisateur INT NOT NULL, lieux_no_lieu INT NOT NULL, etats_no_etat INT NOT NULL, nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, datedebut DATETIME NOT NULL, duree INT DEFAULT NULL, datecloture DATETIME NOT NULL, nbinscriptionsmax INT NOT NULL, descriptioninfos VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, etatsortie INT DEFAULT NULL, urlPhoto VARCHAR(250) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX sorties_etats_fk (etats_no_etat), INDEX sorties_lieux_fk (lieux_no_lieu), INDEX sorties_participants_fk (organisateur), PRIMARY KEY(no_sortie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE PARTICIPANTS (no_participant INT NOT NULL, pseudo VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, prenom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, telephone VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, mail VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, mot_de_passe VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, administrateur TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, sites_no_site INT NOT NULL, UNIQUE INDEX pseudo (pseudo), PRIMARY KEY(no_participant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE SITES (no_site INT NOT NULL, nom_site VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(no_site)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE INSCRIPTIONS ADD CONSTRAINT inscriptions_participants_fk FOREIGN KEY (participants_no_participant) REFERENCES participants (no_participant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE INSCRIPTIONS ADD CONSTRAINT inscriptions_sorties_fk FOREIGN KEY (sorties_no_sortie) REFERENCES sorties (no_sortie) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE LIEUX ADD CONSTRAINT lieux_villes_fk FOREIGN KEY (villes_no_ville) REFERENCES villes (no_ville) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE SORTIES ADD CONSTRAINT sorties_etats_fk FOREIGN KEY (etats_no_etat) REFERENCES etats (no_etat) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE SORTIES ADD CONSTRAINT sorties_lieux_fk FOREIGN KEY (lieux_no_lieu) REFERENCES lieux (no_lieu) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE SORTIES ADD CONSTRAINT sorties_participants_fk FOREIGN KEY (organisateur) REFERENCES participants (no_participant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
