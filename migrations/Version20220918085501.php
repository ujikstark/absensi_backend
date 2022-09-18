<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918085501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user ALTER COLUMN ended_at DROP NOT NULL');
        $this->addSql('ALTER TABLE attendance ALTER COLUMN entered_at DROP NOT NULL');
        $this->addSql('ALTER TABLE attendance ALTER COLUMN exited_at DROP NOT NULL');


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
