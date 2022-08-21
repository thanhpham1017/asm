<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818073803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE phone_store (phone_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_C0D2D6D3B7323CB (phone_id), INDEX IDX_C0D2D6DB092A811 (store_id), PRIMARY KEY(phone_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone_store ADD CONSTRAINT FK_C0D2D6D3B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phone_store ADD CONSTRAINT FK_C0D2D6DB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f529939816a2b381 TO IDX_F52993983B7323CB');
        $this->addSql('ALTER TABLE phone RENAME INDEX idx_cbe5a3314296d31f TO IDX_444F97DD7ADA1FB5');
        $this->addSql('ALTER TABLE phone_producer RENAME INDEX idx_9478d34516a2b381 TO IDX_5F235AD03B7323CB');
        $this->addSql('ALTER TABLE phone_producer RENAME INDEX idx_9478d345f675f31b TO IDX_5F235AD089B658FE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone_store DROP FOREIGN KEY FK_C0D2D6DB092A811');
        $this->addSql('DROP TABLE phone_store');
        $this->addSql('DROP TABLE store');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f52993983b7323cb TO IDX_F529939816A2B381');
        $this->addSql('ALTER TABLE phone RENAME INDEX idx_444f97dd7ada1fb5 TO IDX_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE phone_producer RENAME INDEX idx_5f235ad089b658fe TO IDX_9478D345F675F31B');
        $this->addSql('ALTER TABLE phone_producer RENAME INDEX idx_5f235ad03b7323cb TO IDX_9478D34516A2B381');
    }
}
