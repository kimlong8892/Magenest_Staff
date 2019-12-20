<?php

namespace Magenest\Staff\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.3') < 0) {
            $this->addTableStaff($setup);
        }
    }
    protected function addTableStaff($setup)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
        // create table magenest_director
        $table = $installer->getConnection()->newTable(
            $installer->getTable('magenest_staff')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => false,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            255,
            [
                'nullable' => false
            ],
            'name'
        )->addColumn(
            'nick_name',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'nick_name'
        )->addColumn(
            'type',
            Table::TYPE_INTEGER,
            255,
            [
                'nullable' => false
            ],
            'type'
        )->addColumn(
            'status',
            Table::TYPE_INTEGER,
            255,
            [
                'nullable' => false
            ],
            'status'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            255,
            [
                'nullable' => false
            ],
            'updated_at'
        );
        $installer->getConnection()->createTable($table);
        $installer->getConnection()->addIndex(
            $installer->getTable('magenest_staff'),
            $setup->getIdxName(
                $installer->getTable('magenest_staff'),
                ['nick_name'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['nick_name'],
            AdapterInterface::INDEX_TYPE_FULLTEXT
        );

        $installer->endSetup();
    }
}
