<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419080755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_skills (post_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_E513F2154B89032C (post_id), INDEX IDX_E513F2157FF61858 (skills_id), PRIMARY KEY(post_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_skills ADD CONSTRAINT FK_E513F2154B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_skills ADD CONSTRAINT FK_E513F2157FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_skills DROP FOREIGN KEY FK_E513F2154B89032C');
        $this->addSql('ALTER TABLE post_skills DROP FOREIGN KEY FK_E513F2157FF61858');
        $this->addSql('DROP TABLE post_skills');
    }
}
