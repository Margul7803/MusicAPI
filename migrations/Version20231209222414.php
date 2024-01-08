<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231209222414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE album_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE artiste_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE musique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE album (id INT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE artiste (id INT NOT NULL, nom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, bio VARCHAR(255) NOT NULL, reseau VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE musique (id INT NOT NULL, album_id INT DEFAULT NULL, genre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, duree INT NOT NULL, date_sortie DATE NOT NULL, parole TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EE1D56BC1137ABCF ON musique (album_id)');
        $this->addSql('CREATE INDEX IDX_EE1D56BC4296D31F ON musique (genre_id)');
        $this->addSql('CREATE TABLE musique_artiste (musique_id INT NOT NULL, artiste_id INT NOT NULL, PRIMARY KEY(musique_id, artiste_id))');
        $this->addSql('CREATE INDEX IDX_1BFA3AC25E254A1 ON musique_artiste (musique_id)');
        $this->addSql('CREATE INDEX IDX_1BFA3AC21D25844 ON musique_artiste (artiste_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, artiste_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64921D25844 ON "user" (artiste_id)');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BC1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BC4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique_artiste ADD CONSTRAINT FK_1BFA3AC25E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique_artiste ADD CONSTRAINT FK_1BFA3AC21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64921D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE album_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE artiste_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE musique_id_seq CASCADE');
        $this->addSql('ALTER TABLE musique DROP CONSTRAINT FK_EE1D56BC1137ABCF');
        $this->addSql('ALTER TABLE musique DROP CONSTRAINT FK_EE1D56BC4296D31F');
        $this->addSql('ALTER TABLE musique_artiste DROP CONSTRAINT FK_1BFA3AC25E254A1');
        $this->addSql('ALTER TABLE musique_artiste DROP CONSTRAINT FK_1BFA3AC21D25844');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64921D25844');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE musique');
        $this->addSql('DROP TABLE musique_artiste');
        $this->addSql('DROP TABLE "user"');
    }
}
