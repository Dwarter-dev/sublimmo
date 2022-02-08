<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208144816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maison ADD commercial_id INT NOT NULL');
        $this->addSql('ALTER TABLE maison ADD CONSTRAINT FK_F90CB66D7854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id)');
        $this->addSql('CREATE INDEX IDX_F90CB66D7854071C ON maison (commercial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commercial CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE maison DROP FOREIGN KEY FK_F90CB66D7854071C');
        $this->addSql('DROP INDEX IDX_F90CB66D7854071C ON maison');
        $this->addSql('ALTER TABLE maison DROP commercial_id, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surface surface VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE rooms rooms VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bedrooms bedrooms VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE price price VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img1 img1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img2 img2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
