<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111165543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE artiste (id INT NOT NULL, nom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, bio VARCHAR(255) NOT NULL, reseau VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE musique (id INT NOT NULL, album_id INT DEFAULT NULL, genre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, duree INT NOT NULL, date_sortie DATE NOT NULL, parole TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EE1D56BC1137ABCF ON musique (album_id)');
        $this->addSql('CREATE INDEX IDX_EE1D56BC4296D31F ON musique (genre_id)');
        $this->addSql('CREATE TABLE musique_artiste (musique_id INT NOT NULL, artiste_id INT NOT NULL, PRIMARY KEY(musique_id, artiste_id))');
        $this->addSql('CREATE INDEX IDX_1BFA3AC25E254A1 ON musique_artiste (musique_id)');
        $this->addSql('CREATE INDEX IDX_1BFA3AC21D25844 ON musique_artiste (artiste_id)');
        $this->addSql('CREATE TABLE playlist (id INT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D782112DA76ED395 ON playlist (user_id)');
        $this->addSql('CREATE TABLE playlist_musique (playlist_id INT NOT NULL, musique_id INT NOT NULL, PRIMARY KEY(playlist_id, musique_id))');
        $this->addSql('CREATE INDEX IDX_512241A66BBD148 ON playlist_musique (playlist_id)');
        $this->addSql('CREATE INDEX IDX_512241A625E254A1 ON playlist_musique (musique_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, artiste_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64921D25844 ON "user" (artiste_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BC1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BC4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique_artiste ADD CONSTRAINT FK_1BFA3AC25E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique_artiste ADD CONSTRAINT FK_1BFA3AC21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_musique ADD CONSTRAINT FK_512241A66BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_musique ADD CONSTRAINT FK_512241A625E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64921D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE musique DROP CONSTRAINT FK_EE1D56BC1137ABCF');
        $this->addSql('ALTER TABLE musique DROP CONSTRAINT FK_EE1D56BC4296D31F');
        $this->addSql('ALTER TABLE musique_artiste DROP CONSTRAINT FK_1BFA3AC25E254A1');
        $this->addSql('ALTER TABLE musique_artiste DROP CONSTRAINT FK_1BFA3AC21D25844');
        $this->addSql('ALTER TABLE playlist DROP CONSTRAINT FK_D782112DA76ED395');
        $this->addSql('ALTER TABLE playlist_musique DROP CONSTRAINT FK_512241A66BBD148');
        $this->addSql('ALTER TABLE playlist_musique DROP CONSTRAINT FK_512241A625E254A1');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64921D25844');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE musique');
        $this->addSql('DROP TABLE musique_artiste');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_musique');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
