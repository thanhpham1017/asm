<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801064139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, address VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, color_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, date DATE NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_CBE5A3314296D31F (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone_producer (phone_id INT NOT NULL, producer_id INT NOT NULL, INDEX IDX_9478D34516A2B381 (phone_id), INDEX IDX_9478D345F675F31B (producer_id), PRIMARY KEY(phone_id, producer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE phone_producer ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phone_producer ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (producer_id) REFERENCES producer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone_producer DROP FOREIGN KEY FK_9478D345F675F31B');
        $this->addSql('ALTER TABLE phone_producer DROP FOREIGN KEY FK_9478D34516A2B381');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_CBE5A3314296D31F');
        $this->addSql('DROP TABLE producer');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE phone_producer');
        $this->addSql('DROP TABLE color');
    }
}
