<?php
namespace Training\Elogic\Model\Vendor;

use Magento\Framework\App\Request\DataPersistorInterface;
use Training\Elogic\Model\ResourceModel\Vendor\CollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'training/elogic/vendor/image/';

    /**
     * @var array
     */
    public $_storeManager;

    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $vendordCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $vendordCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $vendordCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->_storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $baseurl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $vendor) {
            $temp = $vendor->getData();

            if ($temp['logo']):
                $img = [];
            $img[0]['image'] = $temp['logo'];
            $img[0]['url'] = $baseurl . $this->subDir . $temp['logo'];
            $temp['logo'] = $img;
            endif;

            $data = $this->dataPersistor->get('vendor');

            if (!empty($data)) {
                $vendor = $this->collection->getNewEmptyItem();
                $vendor->setData($data);
                $this->loadedData[$vendor->getLabelId()] = $vendor->getData();
                $this->dataPersistor->clear('vendor');
            } else {
                if ($items):
                    if ($vendor->getData('logo') != null) {
                        $t2[$vendor->getId()] = $temp;
                        return $t2;
                    } else {
                        return $this->loadedData;
                    }
                endif;
            }

            return $this->loadedData;
        }
    }
}
