<?php
namespace Training\Elogic\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Class FixProductInputTypeAttribute
 * @package Training\Elogic\Setup\Patch\Data
 */
class FixProductInputTypeAttribute implements DataPatchInterface,PatchRevertableInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * CreateIsMagicConfigurableProductAttribute constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(EavSetupFactory $eavSetupFactory, ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'product_vendor');
        $eavSetup->addAttribute(
            Product::ENTITY,
            'product_vendor',
            [
                'group' => 'General',
                'type' => 'text',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'frontend' => '',
                'label' => 'Vendor of product',
                'input' => 'multiselect',
                'note' => '',
                'class' => '',
                'source' => 'Training\Elogic\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'option' => [
                    'values' => [],
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        if(!$eavSetup->getAttributeId(\Magento\Catalog\Model\Product::ENTITY, 'product_vendor')) {
            $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'product_vendor');
        }

        $eavSetup->addAttribute(
            Product::ENTITY,
            'product_vendor',
            [
                'group' => 'General',
                'type' => 'text',
                'backend' => '',
                'frontend' => '',
                'label' => 'Vendor of product',
                'input' => 'select',
                'note' => '',
                'class' => '',
                'source' => 'Training\Elogic\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'option' => [
                    'values' => [],
                ]
            ]
        );
    }
}