<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126094342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE athlete (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, status INT NOT NULL, date DATETIME NOT NULL, cote DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE bet_choices (id INT AUTO_INCREMENT NOT NULL, choice INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE bet_template (id INT AUTO_INCREMENT NOT NULL, sport_type_id INT NOT NULL, description LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_3E34652D64F9C039 (sport_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE bet_template_choice (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, update_description VARCHAR(255) NOT NULL, INDEX IDX_8A9EEA702FC0CB0F (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, cart_item_id INT NOT NULL, INDEX IDX_BA388B7E9B59A59 (cart_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, bet_id INT NOT NULL, bet_choices_id INT NOT NULL, UNIQUE INDEX UNIQ_F0FE2527D871DC26 (bet_id), UNIQUE INDEX UNIQ_F0FE252796687910 (bet_choices_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE encounter_event (id INT AUTO_INCREMENT NOT NULL, sport_type_id INT NOT NULL, sport_event_id INT NOT NULL, INDEX IDX_66F172164F9C039 (sport_type_id), INDEX IDX_66F172147551731 (sport_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE sport_event (id INT AUTO_INCREMENT NOT NULL, lieu VARCHAR(255) NOT NULL, competition VARCHAR(255) NOT NULL, timezone DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE sport_team (id INT AUTO_INCREMENT NOT NULL, team_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE sport_team_athlete (sport_team_id INT NOT NULL, athlete_id INT NOT NULL, INDEX IDX_A09E23F788D99404 (sport_team_id), INDEX IDX_A09E23F7FE6BCB8B (athlete_id), PRIMARY KEY(sport_team_id, athlete_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE sport_team_sport_event (sport_team_id INT NOT NULL, sport_event_id INT NOT NULL, INDEX IDX_CB57F96F88D99404 (sport_team_id), INDEX IDX_CB57F96F47551731 (sport_event_id), PRIMARY KEY(sport_team_id, sport_event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE sport_type (id INT AUTO_INCREMENT NOT NULL, name_type VARCHAR(255) NOT NULL, nbr_athlete_active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, date DATETIME NOT NULL, bet_amount DOUBLE PRECISION NOT NULL, INDEX IDX_723705D1712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, cart_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, verified TINYINT(1) NOT NULL, activated TINYINT(1) NOT NULL, timezone DATETIME NOT NULL, creation_date DATE NOT NULL, birth_date DATE NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, activated_since DATE NOT NULL, suspended TINYINT(1) NOT NULL, suspended_since DATE DEFAULT NULL, deleted TINYINT(1) NOT NULL, deleted_since DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649712520F3 (wallet_id), UNIQUE INDEX UNIQ_8D93D6491AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, receipt_id INT NOT NULL, INDEX IDX_7C68921F2B5CA896 (receipt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE bet_template ADD CONSTRAINT FK_3E34652D64F9C039 FOREIGN KEY (sport_type_id) REFERENCES sport_type (id)'
        );
        $this->addSql(
            'ALTER TABLE bet_template_choice ADD CONSTRAINT FK_8A9EEA702FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id)'
        );
        $this->addSql(
            'ALTER TABLE cart ADD CONSTRAINT FK_BA388B7E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id)'
        );
        $this->addSql(
            'ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527D871DC26 FOREIGN KEY (bet_id) REFERENCES bet (id)'
        );
        $this->addSql(
            'ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE252796687910 FOREIGN KEY (bet_choices_id) REFERENCES bet_choices (id)'
        );
        $this->addSql(
            'ALTER TABLE encounter_event ADD CONSTRAINT FK_66F172164F9C039 FOREIGN KEY (sport_type_id) REFERENCES sport_type (id)'
        );
        $this->addSql(
            'ALTER TABLE encounter_event ADD CONSTRAINT FK_66F172147551731 FOREIGN KEY (sport_event_id) REFERENCES sport_event (id)'
        );
        $this->addSql(
            'ALTER TABLE sport_team_athlete ADD CONSTRAINT FK_A09E23F788D99404 FOREIGN KEY (sport_team_id) REFERENCES sport_team (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE sport_team_athlete ADD CONSTRAINT FK_A09E23F7FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE sport_team_sport_event ADD CONSTRAINT FK_CB57F96F88D99404 FOREIGN KEY (sport_team_id) REFERENCES sport_team (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE sport_team_sport_event ADD CONSTRAINT FK_CB57F96F47551731 FOREIGN KEY (sport_event_id) REFERENCES sport_event (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE transaction ADD CONSTRAINT FK_723705D1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)'
        );
        $this->addSql(
            'ALTER TABLE user ADD CONSTRAINT FK_8D93D649712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)'
        );
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql(
            'ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F2B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sport_team_athlete DROP FOREIGN KEY FK_A09E23F7FE6BCB8B');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527D871DC26');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE252796687910');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491AD5CDBF');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7E9B59A59');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F2B5CA896');
        $this->addSql('ALTER TABLE encounter_event DROP FOREIGN KEY FK_66F172147551731');
        $this->addSql('ALTER TABLE sport_team_sport_event DROP FOREIGN KEY FK_CB57F96F47551731');
        $this->addSql('ALTER TABLE sport_team_athlete DROP FOREIGN KEY FK_A09E23F788D99404');
        $this->addSql('ALTER TABLE sport_team_sport_event DROP FOREIGN KEY FK_CB57F96F88D99404');
        $this->addSql('ALTER TABLE bet_template DROP FOREIGN KEY FK_3E34652D64F9C039');
        $this->addSql('ALTER TABLE encounter_event DROP FOREIGN KEY FK_66F172164F9C039');
        $this->addSql('ALTER TABLE bet_template_choice DROP FOREIGN KEY FK_8A9EEA702FC0CB0F');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1712520F3');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649712520F3');
        $this->addSql('DROP TABLE athlete');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE bet_choices');
        $this->addSql('DROP TABLE bet_template');
        $this->addSql('DROP TABLE bet_template_choice');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE encounter_event');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE sport_event');
        $this->addSql('DROP TABLE sport_team');
        $this->addSql('DROP TABLE sport_team_athlete');
        $this->addSql('DROP TABLE sport_team_sport_event');
        $this->addSql('DROP TABLE sport_type');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wallet');
    }
}
