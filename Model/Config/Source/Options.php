<?php
namespace Training\Elogic\Model\Config\Source;

use Training\Elogic\Model\VendorFactory;

/**
 * Class Options
 * @package Training\Elogic\Model\Config\Source
 */
class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var VendorFactory
     */
    private $vendorFactory;

    /**
     * @param VendorFactory $vendorFactory
     */
    public function __construct(VendorFactory $vendorFactory)
    {
        $this->vendorFactory = $vendorFactory;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $customCollection = $this->vendorFactory->create()->getCollection();
        $this->_options = [['label'=>'Please select', 'value'=>'']];
        foreach ($customCollection as $custom) {
            $this->_options[] = ['label'=> $custom->getTitle(), 'value' => $custom->getId()];
        }
        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
