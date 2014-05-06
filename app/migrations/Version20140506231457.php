<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140506231457 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_product_variant_price DROP INDEX UNIQ_C9425BDB3B69A9AF, ADD INDEX IDX_C9425BDB3B69A9AF (variant_id)");
        $this->addSql("ALTER TABLE sylius_product_variant_price CHANGE variant_id variant_id INT DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE sylius_product_variant_price DROP INDEX IDX_C9425BDB3B69A9AF, ADD UNIQUE INDEX UNIQ_C9425BDB3B69A9AF (variant_id)");
        $this->addSql("ALTER TABLE sylius_product_variant_price CHANGE variant_id variant_id INT NOT NULL");
    }
}
