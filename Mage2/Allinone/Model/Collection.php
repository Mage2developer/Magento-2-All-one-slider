<?php
/**
 * Product Name: Mage2 All in one
 * Module Name: Mage2_Allinone
 * Created By: Yogesh Shishangiya
 */

declare(strict_types=1);

namespace Mage2\Allinone\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory as ReportsCollectionFactory;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestsellersCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Mage2\Allinone\Model\Config as AllinoneConfig;

/**
 * Class Collection
 */
class Collection
{
    /**
     * Is featured enable constant
     */
    const IS_FEATURED_ENABLE = 1;

    /**
     * @var Config
     */
    protected $extConfig;

    /**
     * @var ReportsCollectionFactory
     */
    protected $reportCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var BestsellersCollectionFactory
     */
    protected $bestCollectionFactory;

    /**
     * Collection constructor.
     *
     * @param Config $extConfig
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ReportsCollectionFactory $reportCollectionFactory
     * @param BestsellersCollectionFactory $bestCollectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        AllinoneConfig $extConfig,
        ProductCollectionFactory $productCollectionFactory,
        ReportsCollectionFactory $reportCollectionFactory,
        BestsellersCollectionFactory $bestCollectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->extConfig                = $extConfig;
        $this->reportCollectionFactory  = $reportCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->bestCollectionFactory    = $bestCollectionFactory;
        $this->storeManager             = $storeManager;
    }

    /**
     * Get featured products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getFeatureProducts()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('is_featured', self::IS_FEATURED_ENABLE);
        $collection->addAttributeToFilter('visibility', Visibility::VISIBILITY_BOTH);
        $collection->addAttributeToFilter('status', Status::STATUS_ENABLED);
        $collection->setPageSize($this->extConfig->getFeatureProductCount());
        return $collection;
    }

    /**
     * Get new products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getNewProducts()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('visibility', Visibility::VISIBILITY_BOTH);
        $collection->addAttributeToFilter('status', Status::STATUS_ENABLED);
        $collection->setOrder('entity_id', 'DESC');
        $collection->setPageSize($this->extConfig->getFeatureProductCount());
        return $collection;
    }

    /**
     * Get best sellers product collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBestsellerProducts()
    {
        $productIds = [];
        $storeId    = $this->storeManager->getStore()->getId();
        $bestSellers = $this->bestCollectionFactory->create()->setPeriod('month');

        foreach ($bestSellers as $product) {
            $productIds[] = $product->getProductId();
        }

        $collection = $this->productCollectionFactory->create()->addIdFilter($productIds);
        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect('*')
            ->addStoreFilter($storeId)
            ->setPageSize($this->extConfig->getBestProductCount());

        return $collection;
    }

    /**
     * Get most viewed products collection
     *
     * @return \Magento\Framework\DataObject[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMostViewedProducts()
    {
        $storeId    = $this->storeManager->getStore()->getId();
        $collection = $this->reportCollectionFactory->create()
            ->addAttributeToSelect(
                '*'
            )->addViewsCount()->setStoreId(
                $storeId
            )->addStoreFilter(
                $storeId
            );
        $collection->setPageSize($this->extConfig->getMostProductCount());
        $items = $collection->getItems();
        return $items;
    }
}
