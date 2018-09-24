<?php

namespace Mage2\Allinone\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config {

    const FEATURE_ENABLE_SETTING = 'mage2_allinone_section/general/enabled';
    const FEATURE_BLOCK_TITLE = 'mage2_allinone_section/general/featuretitle';
    const FEATURE_PRODUCT_COUNT = 'mage2_allinone_section/general/featureproductcount';
    
    const NEW_ENABLE_SETTING = 'mage2_allinone_section/general/newenabled';
    const NEW_BLOCK_TITLE = 'mage2_allinone_section/general/newtitle';
    const NEW_PRODUCT_COUNT = 'mage2_allinone_section/general/newproductcount';
    
    const MOST_ENABLE_SETTING = 'mage2_allinone_section/general/mostenabled';
    const MOST_PRODUCT_COUNT = 'mage2_allinone_section/general/mostproductcount';
    const MOST_BLOCK_TITLE = 'mage2_allinone_section/general/mosttitle';
    
    const BEST_ENABLE_SETTING = 'mage2_allinone_section/general/bestenabled';
    const BEST_BLOCK_TITLE = 'mage2_allinone_section/general/besttitle';
    const BEST_PRODUCT_COUNT = 'mage2_allinone_section/general/bestproductcount';

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getFeatureEnable(){
        return $this->getConfig(self::FEATURE_ENABLE_SETTING);
    }

    public function getFeatureProductCount()
    {
        return $this->getConfig(self::FEATURE_PRODUCT_COUNT) ? $this->getConfig(self::FEATURE_PRODUCT_COUNT) : 16;
    }

    public function getFeatureBlockTitle()
    {
        return $this->getConfig(self::FEATURE_BLOCK_TITLE) ? $this->getConfig(self::FEATURE_BLOCK_TITLE) : "Feature Product";
    }
    
    
    public function getNewEnable(){
        return $this->getConfig(self::NEW_ENABLE_SETTING);
    }

    public function getNewProductCount()
    {
        return $this->getConfig(self::NEW_PRODUCT_COUNT) ? $this->getConfig(self::NEW_PRODUCT_COUNT) : 16;
    }

    public function getNewBlockTitle()
    {
        return $this->getConfig(self::NEW_BLOCK_TITLE) ? $this->getConfig(self::NEW_BLOCK_TITLE) : "New Product";
    }
    
    public function getMostEnable(){
        return $this->getConfig(self::MOST_ENABLE_SETTING);
    }

    public function getMostProductCount()
    {
        return $this->getConfig(self::MOST_PRODUCT_COUNT) ? $this->getConfig(self::MOST_PRODUCT_COUNT) : 16;
    }

    public function getMostBlockTitle()
    {
        return $this->getConfig(self::MOST_BLOCK_TITLE) ? $this->getConfig(self::MOST_BLOCK_TITLE) : "Most Viewable Product";
    }
    
    public function getBestEnable(){
        return $this->getConfig(self::BEST_ENABLE_SETTING);
    }

    public function getBestProductCount()
    {
        return $this->getConfig(self::BEST_PRODUCT_COUNT) ? $this->getConfig(self::BEST_PRODUCT_COUNT) : 16;
    }

    public function getBestBlockTitle()
    {
        return $this->getConfig(self::BEST_BLOCK_TITLE) ? $this->getConfig(self::BEST_BLOCK_TITLE) : "Bestseller Product";
    }


}