<?php
/**
 * advanced-cms.extension
 *
 * @category advanced-cms.extension-module
 * @package  Encomage_AdvancedCms
 * @author   Encomage <hello@encomage.com>
 * @license  OSL https://opensource.org/licenses/OSL-3.0
 * @link     http://encomage.com
 */

namespace Encomage\AdvancedCms\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @category Magento2-module
 * @package  Encomage\AdvancedCms\Setup
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        //CMS Page
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'custom_css',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => '64k',
                'nullable' => true,
                'comment'  => 'Custom CSS',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'custom_js',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => '64k',
                'nullable' => true,
                'comment'  => 'Custom JS',
            ]
        );

        //CMS Block
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_block'),
            'custom_css',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => '64k',
                'nullable' => true,
                'comment'  => 'Custom CSS',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('cms_block'),
            'custom_js',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => '64k',
                'nullable' => true,
                'comment'  => 'Custom JS',
            ]
        );
        $installer->endSetup();
    }
}
