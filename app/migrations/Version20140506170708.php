<?php

namespace Sylius\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140506170708 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE sylius_price_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE sylius_product_variant_price (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, type_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_C9425BDB3B69A9AF (variant_id), INDEX IDX_C9425BDBC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE sylius_product_variant_price ADD CONSTRAINT FK_C9425BDB3B69A9AF FOREIGN KEY (variant_id) REFERENCES sylius_product_variant (id)");
        $this->addSql("ALTER TABLE sylius_product_variant_price ADD CONSTRAINT FK_C9425BDBC54C8C93 FOREIGN KEY (type_id) REFERENCES sylius_order (id)");
        $this->addSql("ALTER TABLE sylius_product_variant DROP price");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE sylius_price_type");
        $this->addSql("DROP TABLE sylius_product_variant_price");
        $this->addSql("ALTER TABLE sylius_product_variant ADD price INT NOT NULL");
    }
}
