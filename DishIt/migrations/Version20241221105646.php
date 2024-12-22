<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221105646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant ADD gerant_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FA500A924 FOREIGN KEY (gerant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EB95123FA500A924 ON restaurant (gerant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FA500A924');
        $this->addSql('DROP INDEX IDX_EB95123FA500A924 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP gerant_id');
    }
}
