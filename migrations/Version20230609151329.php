<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609151329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD segment VARCHAR(20) NOT NULL, ADD body_type VARCHAR(255) NOT NULL, ADD color VARCHAR(255) NOT NULL, ADD fuel VARCHAR(255) NOT NULL, ADD number_of_seats INT NOT NULL, ADD number_of_doors INT NOT NULL, ADD registration_number VARCHAR(255) NOT NULL, ADD technical_examination_date VARCHAR(255) NOT NULL, ADD insurance_expiration_date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP segment, DROP body_type, DROP color, DROP fuel, DROP number_of_seats, DROP number_of_doors, DROP registration_number, DROP technical_examination_date, DROP insurance_expiration_date');
    }
}
