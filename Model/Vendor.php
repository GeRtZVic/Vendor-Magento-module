<?php
namespace Training\Elogic\Model;

use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Training\Elogic\Api\Data\VendorInterface;
use Training\Elogic\Api\Data\VendorExtensionInterface;
use Training\Elogic\Model\ResourceModel\Vendor as ResourceVendor;

/**
 * Class Vendor
 * @package Training\Elogic\Model
 */
class Vendor extends AbstractExtensibleModel implements VendorInterface
{
    const VENDOR_ID = 'id';
    const NAME = 'title';
    const LOGO = 'logo';

    protected function _construct()
    {
        $this->_init(ResourceVendor::class);
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @return mixed|string
     */
    public function getLogo()
    {
        return $this->_getData(self::LOGO);
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->setData(self::LOGO, $logo);
    }

    /**
     * @return ExtensionAttributesInterface|VendorExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param VendorExtensionInterface $extensionAttributes
     */
    public function setExtensionAttributes(VendorExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
