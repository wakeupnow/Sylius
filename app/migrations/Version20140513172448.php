<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140513172448 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_payment_gateway DROP FOREIGN KEY FK_2704C2AB4C3A3BB");
        $this->addSql("ALTER TABLE sylius_payment_gateway ADD CONSTRAINT FK_2704C2AB4C3A3BB FOREIGN KEY (payment_id) REFERENCES sylius_payment (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_payment_gateway DROP FOREIGN KEY FK_2704C2AB4C3A3BB");
        $this->addSql("ALTER TABLE sylius_payment_gateway ADD CONSTRAINT FK_2704C2AB4C3A3BB FOREIGN KEY (payment_id) REFERENCES sylius_payment (id)");
    }
}
