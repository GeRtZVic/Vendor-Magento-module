<?php
namespace Training\Elogic\Block\Catalog\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Training\Elogic\Model\ResourceModel\Vendor;
use Magento\Framework\Registry;
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
     * @var Vendor
     */
    private $vendorResource;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Logo constructor.
     * @param Template\Context $context
     * @param VendorFactory $vendorFactory
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     * @param Vendor $vendorResource
     * @param Registry $registry
     */
    public function __construct(
        Template\Context $context,
        VendorFactory $vendorFactory,
        UrlInterface $urlBuilder,
        Filesystem $fileSystem,
        Vendor $vendorResource,
        Registry $registry
    )
    {
        $this->vendorFactory = $vendorFactory;
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
        $this->vendorResource = $vendorResource;
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * @return Product|mixed
     */
    private function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('current_product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    /**
     * @return bool|string|null |null
     */
    public function getVendorImage()
    {
        $vendor = $this->vendorFactory->create();
        $this->vendorResource->load(
            $vendor,
            $this->getProduct()->getProductVendor(),
            'id'
        );
        if ($vendor->getId()){
            return substr($vendor->getLogo(), 0, 1) == '/' ?
                substr($vendor->getLogo(), 1) :
                $vendor->getLogo();
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
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir . '/image/';
    }
}