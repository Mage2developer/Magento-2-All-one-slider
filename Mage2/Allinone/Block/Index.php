<?php

namespace Mage2\Allinone\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class Index extends  \Magento\Catalog\Block\Product\ListProduct
{
    protected $productCollection;
    
    protected $productloader; 
    
    protected $abstractProduct;  
    
    protected $postDataHelper;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver, 
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory  $productCollectionFactory,    
        \Magento\Catalog\Model\ProductFactory $productloader,
        \Magento\Catalog\Block\Product\AbstractProduct $abstractProduct,
        \Mage2\Allinone\Model\Config $extConfig,    
        \Mage2\Allinone\Model\Collection $productCollection    
    )
    {
        $this->productCollection = $productCollection;
        $this->postDataHelper = $postDataHelper;
        $this->urlHelper = $urlHelper;
        $this->catalogLayer = $layerResolver->get();
        $this->extConfig = $extConfig;
        $this->productloader = $productloader;
        $this->abstractProduct = $abstractProduct;
        parent::__construct($context, $postDataHelper,$layerResolver,$categoryRepository, $urlHelper);
    }

    public function featureProductCollection(){
        return $this->productCollection->getFeatureProducts();
    }
    
    public function featureBlockTitle(){
        return $this->extConfig->getFeatureBlockTitle();
    }
    
    public function newProductCollection(){
        return $this->productCollection->getNewProducts();
    }
    
    public function newBlockTitle(){
        return $this->extConfig->getNewBlockTitle();
    }

    public function bestSellerCollection(){
       return $this->productCollection->getBestsellerProducts();
    }
    
     public function bestBlockTitle(){
        return $this->extConfig->getBestBlockTitle();
    }
    
    public function mostViewedCollection(){
        return $this->productCollection->getMostViewedProducts();
    }
    
    public function mostBlockTitle(){
        return $this->extConfig->getMostBlockTitle();
    }
    
    public function featureStatus()
    {
         return $this->extConfig->getFeatureEnable();
    }
    
    public function newStatus()
    {
         return $this->extConfig->getNewEnable();
    }
    
    public function mostStatus()
    {
         return $this->extConfig->getMostEnable();
    }
    
    public function bestStatus()
    {
         return $this->extConfig->getBestEnable();
    }
    
    public function getProductById($id)
    {
        return $this->productloader->create()->load($id);
    }
    
    public function getPrice($product){
        return $this->abstractProduct->getProductPrice($product);
    }
    
    public function getProductImage($product){
        return $this->abstractProduct->getImage($product, 'latest_collection_list')->getImageUrl(); 
    }
}