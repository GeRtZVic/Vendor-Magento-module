<?php
namespace Training\Elogic\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Training\Elogic\Api\Data\VendorInterface;
use Training\Elogic\Api\VendorRepositoryInterface;
use Training\Elogic\Api\Data\VendorSearchResultInterface;
use Training\Elogic\Api\Data\VendorSearchResultInterfaceFactory;
use Training\Elogic\Model\ResourceModel\Vendor\Collection;
use Training\Elogic\Model\ResourceModel\Vendor as VendorResource;
use Training\Elogic\Model\ResourceModel\Vendor\CollectionFactory as VendorCollectionFactory;

/**
 * Class VendorRepository
 * @package Training\Elogic\Model
 */
class VendorRepository implements VendorRepositoryInterface
{
    /**
     * @var VendorFactory
     */
    private $vendorFactory;

    /**
     * @var VendorCollectionFactory
     */
    private $vendorCollectionFactory;

    /**
     * @var VendorSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var VendorResource
     */
    private $vendorResource;

    /**
     * VendorRepository constructor.
     * @param VendorFactory $vendorFactory
     * @param VendorCollectionFactory $vendorCollectionFactory
     * @param VendorSearchResultInterfaceFactory $vendorSearchResultInterfaceFactory
     * @param VendorResource $vendorResource
     */
    public function __construct(
        VendorFactory $vendorFactory,
        VendorCollectionFactory $vendorCollectionFactory,
        VendorSearchResultInterfaceFactory $vendorSearchResultInterfaceFactory,
        VendorResource $vendorResource
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
        $this->searchResultFactory = $vendorSearchResultInterfaceFactory;
        $this->vendorResource = $vendorResource;
    }

    /**
     * @param int $id
     * @return VendorInterface|Vendor
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $vendor = $this->vendorFactory->create();
        $this->vendorResource->load($vendor, $id);
        if (! $vendor->getId()) {
            throw new NoSuchEntityException(__('Unable to find vendor with ID "%1"', $id));
        }
        return $vendor;
    }

    /**
     * @param VendorInterface $vendor
     * @return VendorInterface
     */
    public function save(VendorInterface $vendor)
    {
        $vendor->getResource()->save($vendor);
        return $vendor;
    }

    /**
     * @param VendorInterface $vendor
     */
    public function delete(VendorInterface $vendor)
    {
        $vendor->getResource()->delete($vendor);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return VendorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}