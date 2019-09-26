<?php
namespace Training\Elogic\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Vendor
 * @package Training\Elogic\Model\ResourceModel
 */
class Vendor extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vendor', 'id');
    }
}