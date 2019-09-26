<?php
namespace Training\Elogic\Model\ResourceModel\Vendor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Training\Elogic\Model\ResourceModel\Vendor as VendorResource;
use Training\Elogic\Model\Vendor;

/**
 * Class Collection
 * @package Training\Elogic\Model\ResourceModel\Vendor
 */
class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = \Training\Elogic\Model\Vendor::VENDOR_ID;

    protected function _construct()
    {
        $this->_init(Vendor::class, VendorResource::class);
    }
}
