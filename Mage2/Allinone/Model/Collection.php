<?php

namespace Mage2\Allinone\Model;


class Collection {

    const ENABLE = 1;

    protected $extConfig;

    protected $reportCollectionFactory;
    
    protected $storeManager;
    
    protected $bestCollectionFactory;

    public function __construct(
        \Mage2\Allinone\Model\Config $extConfig,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory  $productCollectionFactory,
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $reportCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestCollectionFactory,      
        \Magento\Store\Model\StoreManagerInterface $storeManager   
    ){
        $this->extConfig = $extConfig;
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->bestCollectionFactory = $bestCollectionFactory;
        $this->storeManager = $storeManager;
    }

    public function getFeatureProducts(){
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('is_featured',self::ENABLE);
        $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->setPageSize($this->extConfig->getFeatureProductCount());
        return $collection;
    }
    
    

    public function getNewProducts(){
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->setOrder('entity_id','DESC');
        $collection->setPageSize($this->extConfig->getFeatureProductCount());
        return $collection;
    }

    public function getBestsellerProducts()
    {
       
       $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       $productCollection = $objectManager->create('Magento\Reports\Model\ResourceModel\Report\Collection\Factory'); 
       $collection = $productCollection->create('Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection'); 
       $collection->setPageSize($this->extConfig->getBestProductCount());
       return $collection;

    }
    
    public function getMostViewedProducts()
    {
          $storeId =  $this->storeManager->getStore()->getId();
          
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