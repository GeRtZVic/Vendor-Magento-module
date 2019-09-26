<?php
namespace Training\Elogic\Block\Catalog\Product\View;

use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Training\Elogic\Model\VendorFactory;

/**
 * Class Logo
 * @package Training\Elogic\Block\Catalog\Product\View
 */
class Logo extends Template
{
    /**
     * @var VendorFactory $vendorFactory
     */
    private $vendorFactory;

    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'training/elogic/vendor';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * Logo constructor.
     * @param Template\Context $context
     * @param VendorFactory $vendorFactory
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     */
    public function __construct(
        Template\Context $context,
        VendorFactory $vendorFactory,
        UrlInterface $urlBuilder,
        Filesystem $fileSystem
    )
    {
        $this->vendorFactory = $vendorFactory;
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
        parent::__construct($context);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVendorImage($id)
    {
        $customCollection = $this->vendorFactory
            ->create()->getCollection()->addFieldToFilter('id', $id);
        foreach ($customCollection as $custom) {
            return $custom->getLogo();
        }
        return null;
    }

    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir . '/image';
    }
}