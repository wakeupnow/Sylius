<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140513161731 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_gateway ADD payment_method_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE sylius_gateway ADD CONSTRAINT FK_A0CF42A65AA1164F FOREIGN KEY (payment_method_id) REFERENCES sylius_payment_method (id) ON DELETE SET NULL");
        $this->addSql("CREATE INDEX IDX_A0CF42A65AA1164F ON sylius_gateway (payment_method_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_gateway DROP FOREIGN KEY FK_A0CF42A65AA1164F");
        $this->addSql("DROP INDEX IDX_A0CF42A65AA1164F ON sylius_gateway");
        $this->addSql("ALTER TABLE sylius_gateway DROP payment_method_id");
    }
}
