<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611095614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_participant (history_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_49B56C781E058452 (history_id), INDEX IDX_49B56C789D1C3019 (participant_id), PRIMARY KEY(history_id, participant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_question (history_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_F60C25041E058452 (history_id), INDEX IDX_F60C25041E27F6BF (question_id), PRIMARY KEY(history_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_proposition (history_id INT NOT NULL, proposition_id INT NOT NULL, INDEX IDX_59E7C43A1E058452 (history_id), INDEX IDX_59E7C43ADB96F9E (proposition_id), PRIMARY KEY(history_id, proposition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history_participant ADD CONSTRAINT FK_49B56C781E058452 FOREIGN KEY (history_id) REFERENCES history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history_participant ADD CONSTRAINT FK_49B56C789D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history_question ADD CONSTRAINT FK_F60C25041E058452 FOREIGN KEY (history_id) REFERENCES history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history_question ADD CONSTRAINT FK_F60C25041E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history_proposition ADD CONSTRAINT FK_59E7C43A1E058452 FOREIGN KEY (history_id) REFERENCES history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history_proposition ADD CONSTRAINT FK_59E7C43ADB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE history_participant DROP FOREIGN KEY FK_49B56C781E058452');
        $this->addSql('ALTER TABLE history_question DROP FOREIGN KEY FK_F60C25041E058452');
        $this->addSql('ALTER TABLE history_proposition DROP FOREIGN KEY FK_59E7C43A1E058452');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE history_participant');
        $this->addSql('DROP TABLE history_question');
        $this->addSql('DROP TABLE history_proposition');
    }
}
