<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140507130949 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_product_variant_price DROP FOREIGN KEY FK_C9425BDBC54C8C93");
        $this->addSql("ALTER TABLE sylius_product_variant_price ADD CONSTRAINT FK_C9425BDBC54C8C93 FOREIGN KEY (type_id) REFERENCES sylius_price_type (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_product_variant_price DROP FOREIGN KEY FK_C9425BDBC54C8C93");
        $this->addSql("ALTER TABLE sylius_product_variant_price ADD CONSTRAINT FK_C9425BDBC54C8C93 FOREIGN KEY (type_id) REFERENCES sylius_order (id)");
    }
}
