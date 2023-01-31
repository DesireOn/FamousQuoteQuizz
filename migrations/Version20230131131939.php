<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131131939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_suggestion (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, answer_id INT NOT NULL, is_correct TINYINT(1) NOT NULL, INDEX IDX_BA546C931E27F6BF (question_id), UNIQUE INDEX UNIQ_BA546C93AA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, session VARCHAR(255) NOT NULL, settings JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor_history (id INT AUTO_INCREMENT NOT NULL, visitor_id INT NOT NULL, question_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_E5A9E08370BEE6D (visitor_id), INDEX IDX_E5A9E0831E27F6BF (question_id), INDEX IDX_E5A9E083AA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_suggestion ADD CONSTRAINT FK_BA546C931E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question_suggestion ADD CONSTRAINT FK_BA546C93AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE visitor_history ADD CONSTRAINT FK_E5A9E08370BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id)');
        $this->addSql('ALTER TABLE visitor_history ADD CONSTRAINT FK_E5A9E0831E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE visitor_history ADD CONSTRAINT FK_E5A9E083AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_suggestion DROP FOREIGN KEY FK_BA546C931E27F6BF');
        $this->addSql('ALTER TABLE question_suggestion DROP FOREIGN KEY FK_BA546C93AA334807');
        $this->addSql('ALTER TABLE visitor_history DROP FOREIGN KEY FK_E5A9E08370BEE6D');
        $this->addSql('ALTER TABLE visitor_history DROP FOREIGN KEY FK_E5A9E0831E27F6BF');
        $this->addSql('ALTER TABLE visitor_history DROP FOREIGN KEY FK_E5A9E083AA334807');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_suggestion');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE visitor_history');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
