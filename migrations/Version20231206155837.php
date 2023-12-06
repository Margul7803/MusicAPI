<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206155837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE musique_artiste (musique_id INT NOT NULL, artiste_id INT NOT NULL, PRIMARY KEY(musique_id, artiste_id))');
        $this->addSql('CREATE INDEX IDX_1BFA3AC25E254A1 ON musique_artiste (musique_id)');
        $this->addSql('CREATE INDEX IDX_1BFA3AC21D25844 ON musique_artiste (artiste_id)');
        $this->addSql('ALTER TABLE musique_artiste ADD CONSTRAINT FK_1BFA3AC25E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique_artiste ADD CONSTRAINT FK_1BFA3AC21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique ADD album_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE musique ADD genre_id INT NOT NULL');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BC1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BC4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EE1D56BC1137ABCF ON musique (album_id)');
        $this->addSql('CREATE INDEX IDX_EE1D56BC4296D31F ON musique (genre_id)');
        $this->addSql('ALTER TABLE "user" ADD artiste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64921D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64921D25844 ON "user" (artiste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE musique_artiste DROP CONSTRAINT FK_1BFA3AC25E254A1');
        $this->addSql('ALTER TABLE musique_artiste DROP CONSTRAINT FK_1BFA3AC21D25844');
        $this->addSql('DROP TABLE musique_artiste');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64921D25844');
        $this->addSql('DROP INDEX UNIQ_8D93D64921D25844');
        $this->addSql('ALTER TABLE "user" DROP artiste_id');
        $this->addSql('ALTER TABLE musique DROP CONSTRAINT FK_EE1D56BC1137ABCF');
        $this->addSql('ALTER TABLE musique DROP CONSTRAINT FK_EE1D56BC4296D31F');
        $this->addSql('DROP INDEX IDX_EE1D56BC1137ABCF');
        $this->addSql('DROP INDEX IDX_EE1D56BC4296D31F');
        $this->addSql('ALTER TABLE musique DROP album_id');
        $this->addSql('ALTER TABLE musique DROP genre_id');
    }
}
