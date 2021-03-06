<?php

namespace Scommerce\UiComponent\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Scommerce\UiComponent\Api\Data\TrainingContactInterface;

/**
 * Class InstallSchema
 * @package Scommerce\UiComponent\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $tableName = TrainingContactInterface::TABLE_NAME;

        if (!$installer->tableExists($tableName)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tableName)
            )
                ->addColumn(
                    TrainingContactInterface::ID,
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
                    TrainingContactInterface::NAME,
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false']
                )
                ->addColumn(
                    TrainingContactInterface::IMAGE,
                    Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    TrainingContactInterface::DOB,
                    Table::TYPE_DATE
                )
                ->addColumn(
                    TrainingContactInterface::ABOUT_ME,
                    Table::TYPE_BLOB
                )
                ->addColumn(
                    TrainingContactInterface::RESUME,
                    Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    TrainingContactInterface::ACTIVE,
                    Table::TYPE_SMALLINT
                )
                ->addIndex(
                    $installer->getIdxName($tableName, [TrainingContactInterface::NAME]),
                    [TrainingContactInterface::NAME]
                )
                ->addIndex(
                    $installer->getIdxName($tableName, [TrainingContactInterface::DOB]),
                    [TrainingContactInterface::DOB]
                );

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
