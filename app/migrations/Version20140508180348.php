<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140508180348 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_payment DROP FOREIGN KEY FK_D9191BD419883967");
        $this->addSql("CREATE TABLE sylius_payment_gateway (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, gateway VARCHAR(255) NOT NULL, environment VARCHAR(255) DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE sylius_payment_method");
        $this->addSql("ALTER TABLE sylius_payment DROP FOREIGN KEY FK_D9191BD419883967");
        $this->addSql("ALTER TABLE sylius_payment ADD CONSTRAINT FK_D9191BD419883967 FOREIGN KEY (method_id) REFERENCES sylius_payment_gateway (id) ON DELETE SET NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_payment DROP FOREIGN KEY FK_D9191BD419883967");
        $this->addSql("CREATE TABLE sylius_payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, gateway VARCHAR(255) NOT NULL, environment VARCHAR(255) DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE sylius_payment_gateway");
        $this->addSql("ALTER TABLE sylius_payment DROP FOREIGN KEY FK_D9191BD419883967");
        $this->addSql("ALTER TABLE sylius_payment ADD CONSTRAINT FK_D9191BD419883967 FOREIGN KEY (method_id) REFERENCES sylius_payment_method (id) ON DELETE SET NULL");
    }
}
