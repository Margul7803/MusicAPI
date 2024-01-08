<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108154531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ALTER pseudo DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER tel DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ALTER pseudo SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER tel SET NOT NULL');
    }
}
