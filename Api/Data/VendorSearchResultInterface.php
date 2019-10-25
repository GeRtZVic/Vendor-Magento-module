<?php
namespace Training\Elogic\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface VendorSearchResultInterface
 * @package Training\Elogic\Api\Data
 */
interface VendorSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return VendorInterface[]
     */
    public function getItems();

    /**
     * @param VendorInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}