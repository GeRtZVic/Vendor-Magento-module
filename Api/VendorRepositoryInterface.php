<?php
namespace Training\Elogic\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Training\Elogic\Api\Data\VendorInterface;
use Training\Elogic\Api\Data\VendorSearchResultInterface;

/**
 * Interface VendorRepositoryInterface
 * @package Training\Elogic\Api
 */
interface VendorRepositoryInterface
{
    /**
     * @param int $id
     * @return VendorInterface
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param VendorInterface $vendor
     * @return VendorInterface
     */
    public function save(VendorInterface $vendor);

    /**
     * @param VendorInterface $vendor
     * @return void
     */
    public function delete(VendorInterface $vendor);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return VendorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}