<?php
/**
 * Mage2developer
 * Copyright (C) 2021 Mage2developer
 *
 * @category Mage2developer
 * @package Mage2_Allinone
 * @copyright Copyright (c) 2021 Mage2developer
 * @author Mage2developer <mage2developer@gmail.com>
 */

declare(strict_types=1);

namespace Mage2\Allinone\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory as ReportsCollectionFactory;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestsellersCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

/**
 * Class Collection
 */
class Collection
{
    /**
     * Admin configuration values
     */
    const FEATURED   = 'featured';
    const NEW        = 'new';
    const MOSTVIEWED = 'mostviewed';
    const BESTSELLER = 'bestseller';

    const ENABLED = 'enabled';
    const TITLE   = 'title';
    const COUNT   = 'count';

    const IS_FEATURED_ENABLE = '1';
    const DEFAULT_COUNT      = 16;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var ReportsCollectionFactory
     */
    protected $reportCollectionFactory;

    /**
     * @var BestsellersCollectionFactory
     */
    protected $bestCollectionFactory;

    /**
     * Collection constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ReportsCollectionFactory $reportCollectionFactory
     * @param BestsellersCollectionFactory $bestCollectionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        ProductCollectionFactory $productCollectionFactory,
        ReportsCollectionFactory $reportCollectionFactory,
        BestsellersCollectionFactory $bestCollectionFactory
    )
    {
        $this->scopeConfig              = $scopeConfig;
        $this->storeManager             = $storeManager;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->reportCollectionFactory  = $reportCollectionFactory;
        $this->bestCollectionFactory    = $bestCollectionFactory;
    }

    /**
     * Get block enabled config value from the type of block
     *
     * @param $type
     * @return boolean|string|mixed
     */
    public function getEnabled($type)
    {
        $configPath = 'allinone_section/' . $type . '/' . self::ENABLED;
        return $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get block title config value from the type of block
     *
     * @param $type
     * @return \Magento\Framework\Phrase|mixed
     */
    public function getTitle($type)
    {
        $configPath = 'allinone_section/' . $type . '/' . self::TITLE;
        $title      = $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE);

        if (empty($title)) {
            switch ($type) {
                case self::FEATURED:
                    $title = __("Featured Products");
                    break;
                case self::NEW:
                    $title = __("New Products");
                    break;
                case self::MOSTVIEWED:
                    $title = __("Most Viewable Products");
                    break;
                case self::BESTSELLER:
                    $title = __("Bestseller Products");
                    break;
            }
        }
        return $title;
    }

    /**
     * Get number of products config value from the type of block
     *
     * @param $type
     * @return int|mixed
     */
    public function getCount($type)
    {
        $configPath = 'allinone_section/' . $type . '/' . self::COUNT;
        $countVal   = $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE);
        return $countVal ? $countVal : self::DEFAULT_COUNT;
    }

    /**
     * Get featured products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getFeaturedProducts()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('is_featured', self::IS_FEATURED_ENABLE)
            ->addAttributeToFilter('visibility', Visibility::VISIBILITY_BOTH)
            ->addAttributeToFilter('status', Status::STATUS_ENABLED)
            ->setOrder('entity_id', 'DESC')
            ->setPageSize($this->getCount(self::FEATURED));
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
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('visibility', Visibility::VISIBILITY_BOTH)
            ->addAttributeToFilter('status', Status::STATUS_ENABLED)
            ->setOrder('entity_id', 'DESC')
            ->setPageSize($this->getCount(self::NEW));
        return $collection;
    }

    /**
     * Get bestseller products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBestsellerProducts()
    {
        $productIds  = [];
        $storeId     = $this->storeManager->getStore()->getId();
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
            ->setPageSize($this->getCount(self::BESTSELLER));

        return $collection;
    }

    /**
     * Get most viewable products collection
     *
     * @return \Magento\Reports\Model\ResourceModel\Product\Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMostViewedProducts()
    {
        $storeId    = $this->storeManager->getStore()->getId();
        $collection = $this->reportCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addViewsCount()
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setPageSize($this->getCount(self::MOSTVIEWED));
        //$items = $collection->getItems();
        return $collection;
    }
}
