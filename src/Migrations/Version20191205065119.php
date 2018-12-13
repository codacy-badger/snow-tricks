<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Insert hard data in database tables
 */
final class version20191205065119 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Grab", "A grab consists in catching the board with the hand during the jump")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Rotation", "It concerns only horizontal rotations. The principle is to make a horizontal rotation during the jump, then landing in switch or normal position. The naming bases itself on the number of made degrees of rotation")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Flips", "A flip is a vertical rotation. We distinguish front flip, rotations forward, and back flip, rotations behind")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Slides", "A slide consists in sliding on a bar of slide. The slide is made either with the board in the axis of the bar, or perpendicular, or more or less unbalanced")');
        $this->addSql('INSERT INTO trick_group (name, description) VALUES ("Old School", "The term old school indicates a style of freestyle characterized by together of figure and a way of realizing figures gone out of fashion, which reminds the freestyle of the 1980s - the beginning of 1990")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE trick_group');
    }
}
