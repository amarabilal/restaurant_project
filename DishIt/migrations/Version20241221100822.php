<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221100822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation CHANGE user_id user_id INT NOT NULL, CHANGE table_id table_id INT NOT NULL');
        $this->addSql('ALTER TABLE review CHANGE restaurant_id restaurant_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation CHANGE user_id user_id INT DEFAULT NULL, CHANGE table_id table_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review CHANGE restaurant_id restaurant_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
    }
}
