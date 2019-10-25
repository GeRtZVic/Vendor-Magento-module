<?php
namespace Training\Elogic\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface VendorInterface
 * @package Training\Elogic\Api\Data
 */
interface VendorInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getLogo();

    /**
     * @param string $logo
     * @return void
     */
    public function setLogo($logo);

    /**
     * @return \Training\Elogic\Api\Data\VendorExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param \Training\Elogic\Api\Data\VendorExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(VendorExtensionInterface $extensionAttributes);
}