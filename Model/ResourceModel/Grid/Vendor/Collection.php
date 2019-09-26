<?php
/**
 * Created by PhpStorm.
 * User: gertz
 * Date: 22.06.19
 * Time: 0:29
 */

namespace Training\Elogic\Model\ResourceModel\Grid\Vendor;

use Magento\Framework\Api\Search\AggregationInterface;
use Training\Elogic\Model\ResourceModel\Vendor\Collection as GridCollection;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Training\Elogic\Model\ResourceModel\Vendor;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class Collection
 * @package Training\Elogic\Model\ResourceModel\Grid\Vendor
 */
class Collection extends GridCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface $aggregations
     */
    protected $aggregations;

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(Document::class, Vendor::class);
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return SearchResultInterface|void
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * @return \Magento\Framework\Api\Search\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return $this|SearchResultInterface
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @param int $totalCount
     * @return $this|SearchResultInterface
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this|SearchResultInterface
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}