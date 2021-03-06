<?php

namespace Scommerce\UiComponent\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Scommerce\UiComponent\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    const TRAINING_CONTACT = 'training_contact';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $tableName = self::TRAINING_CONTACT;
        if (!$installer->tableExists($tableName)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tableName)
            )
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false']
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'date_of_birth',
                    Table::TYPE_DATE
                )
                ->addColumn(
                    'about_me',
                    Table::TYPE_BLOB
                )
                ->addColumn(
                    'resume',
                    Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'active',
                    Table::TYPE_SMALLINT
                )
                ->addIndex(
                    $installer->getIdxName($tableName, ['name']),
                    ['name']
                )
                ->addIndex(
                    $installer->getIdxName($tableName, ['date_of_birth']),
                    ['date_of_birth']
                );

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
