<?php
namespace Training\Elogic\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Training\Elogic\Model\VendorFactory;

/**
 * Class Options
 * @package Training\Elogic\Model\Config\Source
 */
class Options extends AbstractSource
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
        $options = [];
        foreach ($customCollection as $custom) {
            $options[] = ['label'=> $custom->getTitle(), 'value' => $custom->getId()];
        }
        return $options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        $vendorsTitle = '';
        $vendorsIds = explode(',',$value);
        foreach ($this->getAllOptions() as $option) {
            if (in_array($option['value'],$vendorsIds)) {
                $vendorsTitle .= empty($vendorsTitle) ? $option['label'] : ', ' . $option['label'];
            }
        }
        return empty($vendorsTitle) ? false : $vendorsTitle;
    }
}
