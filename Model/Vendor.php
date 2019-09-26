<?php
namespace Training\Elogic\Model;

use Magento\Framework\Model\AbstractModel;
use Training\Elogic\Model\ResourceModel\Vendor as ResourceVendor;

/**
 * Class Vendor
 * @package Training\Elogic\Model
 */
class Vendor extends AbstractModel
{
    const VENDOR_ID = 'id';

    protected function _construct()
    {
        $this->_init(ResourceVendor::class);
    }
}
