<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220092427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE criteria (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B61F9B81853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, criteria_id INT NOT NULL, student_id INT NOT NULL, test SMALLINT DEFAULT NULL, interview SMALLINT DEFAULT NULL, INDEX IDX_136AC113990BEA15 (criteria_id), INDEX IDX_136AC113CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, trainer_id INT NOT NULL, fullname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, INDEX IDX_B723AF33FB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_quiz (student_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_9B31814ACB944F1A (student_id), INDEX IDX_9B31814A853CD175 (quiz_id), PRIMARY KEY(student_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, trainer_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A412FA92FB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE criteria ADD CONSTRAINT FK_B61F9B81853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE student_quiz ADD CONSTRAINT FK_9B31814ACB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_quiz ADD CONSTRAINT FK_9B31814A853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113990BEA15');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113CB944F1A');
        $this->addSql('ALTER TABLE student_quiz DROP FOREIGN KEY FK_9B31814ACB944F1A');
        $this->addSql('ALTER TABLE criteria DROP FOREIGN KEY FK_B61F9B81853CD175');
        $this->addSql('ALTER TABLE student_quiz DROP FOREIGN KEY FK_9B31814A853CD175');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33FB08EDF6');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92FB08EDF6');
        $this->addSql('DROP TABLE criteria');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_quiz');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE user');
    }
}
