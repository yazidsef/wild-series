<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240719211051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, episode_id_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, rate INT NOT NULL, INDEX IDX_9474526C9D86650F (user_id_id), INDEX IDX_9474526C444E6803 (episode_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, season_id_id INT NOT NULL, watch_list_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, number INT NOT NULL, synonpsis LONGTEXT NOT NULL, INDEX IDX_DDAA1CDA68756988 (season_id_id), INDEX IDX_DDAA1CDAC4508918 (watch_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, program_actor_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, synopsis LONGTEXT NOT NULL, poster VARCHAR(255) NOT NULL, country VARCHAR(150) NOT NULL, INDEX IDX_92ED778412469DE2 (category_id), INDEX IDX_92ED778491EF0E7F (program_actor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_actor (id INT AUTO_INCREMENT NOT NULL, actor_id_id INT NOT NULL, UNIQUE INDEX UNIQ_DA1C250F5BC075C3 (actor_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, proram_id_id INT NOT NULL, number INT NOT NULL, year DATE NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_F0E45BA9B5F6466F (proram_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, bio LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_list (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, seen TINYINT(1) NOT NULL, adoré TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_152B584B9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C444E6803 FOREIGN KEY (episode_id_id) REFERENCES episode (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA68756988 FOREIGN KEY (season_id_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAC4508918 FOREIGN KEY (watch_list_id) REFERENCES watch_list (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778491EF0E7F FOREIGN KEY (program_actor_id) REFERENCES program_actor (id)');
        $this->addSql('ALTER TABLE program_actor ADD CONSTRAINT FK_DA1C250F5BC075C3 FOREIGN KEY (actor_id_id) REFERENCES actor (id)');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9B5F6466F FOREIGN KEY (proram_id_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE watch_list ADD CONSTRAINT FK_152B584B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C444E6803');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA68756988');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAC4508918');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778412469DE2');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778491EF0E7F');
        $this->addSql('ALTER TABLE program_actor DROP FOREIGN KEY FK_DA1C250F5BC075C3');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9B5F6466F');
        $this->addSql('ALTER TABLE watch_list DROP FOREIGN KEY FK_152B584B9D86650F');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_actor');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE watch_list');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
