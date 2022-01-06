<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106140747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD ticket_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3C980D5C1 ON ticket (ticket_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C980D5C1');
        $this->addSql('DROP INDEX IDX_97A0ADA3C980D5C1 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP ticket_type_id');
    }
}
