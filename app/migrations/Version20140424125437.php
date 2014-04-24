<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140424125437 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE sylius_shipment_state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F364DAA55E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE sylius_payment_state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_187DD0675E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE sylius_payment ADD CONSTRAINT FK_D9191BD45D83CC1 FOREIGN KEY (state_id) REFERENCES sylius_payment_state (id)");
        $this->addSql("ALTER TABLE sylius_shipment ADD CONSTRAINT FK_FD707B335D83CC1 FOREIGN KEY (state_id) REFERENCES sylius_shipment_state (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_shipment DROP FOREIGN KEY FK_FD707B335D83CC1");
        $this->addSql("ALTER TABLE sylius_payment DROP FOREIGN KEY FK_D9191BD45D83CC1");
        $this->addSql("DROP TABLE sylius_shipment_state");
        $this->addSql("DROP TABLE sylius_payment_state");
    }
}
