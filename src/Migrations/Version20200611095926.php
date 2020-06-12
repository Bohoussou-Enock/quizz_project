<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611095926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score_quiz (score_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_8E0A7BE412EB0A51 (score_id), INDEX IDX_8E0A7BE4853CD175 (quiz_id), PRIMARY KEY(score_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score_participant (score_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_12D4DA6412EB0A51 (score_id), INDEX IDX_12D4DA649D1C3019 (participant_id), PRIMARY KEY(score_id, participant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE score_quiz ADD CONSTRAINT FK_8E0A7BE412EB0A51 FOREIGN KEY (score_id) REFERENCES score (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE score_quiz ADD CONSTRAINT FK_8E0A7BE4853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE score_participant ADD CONSTRAINT FK_12D4DA6412EB0A51 FOREIGN KEY (score_id) REFERENCES score (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE score_participant ADD CONSTRAINT FK_12D4DA649D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE score_quiz DROP FOREIGN KEY FK_8E0A7BE412EB0A51');
        $this->addSql('ALTER TABLE score_participant DROP FOREIGN KEY FK_12D4DA6412EB0A51');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE score_quiz');
        $this->addSql('DROP TABLE score_participant');
    }
}
