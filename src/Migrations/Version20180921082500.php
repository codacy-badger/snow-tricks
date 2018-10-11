<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Init database tables
 */
final class Version20180921082500 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, video_code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, platform VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trick_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), INDEX IDX_B6BD307FB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, filename VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_14B78418B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trick_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_D8F0A91EA76ED395 (user_id), INDEX IDX_D8F0A91E9B875DF8 (trick_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_video (trick_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_B7E8DA93B281BE2E (trick_id), INDEX IDX_B7E8DA9329C1004E (video_id), PRIMARY KEY(trick_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E9B875DF8 FOREIGN KEY (trick_group_id) REFERENCES trick_group (id)');
        $this->addSql('ALTER TABLE trick_video ADD CONSTRAINT FK_B7E8DA93B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_video ADD CONSTRAINT FK_B7E8DA9329C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');

        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Grab", "A grab consists in catching the board with the hand during the jump")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Rotation", "It concerns only horizontal rotations. The principle is to make a horizontal rotation during the jump, then landing in switch or normal position. The naming bases itself on the number of made degrees of rotation")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Flips", "A flip is a vertical rotation. We distinguish front flip, rotations forward, and back flip, rotations behind")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Slides", "A slide consists in sliding on a bar of slide. The slide is made either with the board in the axis of the bar, or perpendicular, or more or less unbalanced")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Old School", "The term old school indicates a style of freestyle characterized by together of figure and a way of realizing figures gone out of fashion, which reminds the freestyle of the 1980s - the beginning of 1990")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trick_video DROP FOREIGN KEY FK_B7E8DA9329C1004E');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB281BE2E');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418B281BE2E');
        $this->addSql('ALTER TABLE trick_video DROP FOREIGN KEY FK_B7E8DA93B281BE2E');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E9B875DF8');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE trick_video');
        $this->addSql('DROP TABLE trick_group');
    }
}
