<?php
/**
 * Product Name: Mage2 All in one
 * Module Name: Mage2_Allinone
 * Created By: Yogesh Shishangiya
 */

declare(strict_types=1);

namespace Mage2\Allinone\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * Mage2 All in one module's admin configurations
     */
    const FEATURE_ENABLE_SETTING = 'mage2_allinone_section/general/enabled';
    const FEATURE_BLOCK_TITLE    = 'mage2_allinone_section/general/featuretitle';
    const FEATURE_PRODUCT_COUNT  = 'mage2_allinone_section/general/featureproductcount';

    const NEW_ENABLE_SETTING = 'mage2_allinone_section/general/newenabled';
    const NEW_BLOCK_TITLE    = 'mage2_allinone_section/general/newtitle';
    const NEW_PRODUCT_COUNT  = 'mage2_allinone_section/general/newproductcount';

    const MOST_ENABLE_SETTING = 'mage2_allinone_section/general/mostenabled';
    const MOST_PRODUCT_COUNT  = 'mage2_allinone_section/general/mostproductcount';
    const MOST_BLOCK_TITLE    = 'mage2_allinone_section/general/mosttitle';

    const BEST_ENABLE_SETTING = 'mage2_allinone_section/general/bestenabled';
    const BEST_BLOCK_TITLE    = 'mage2_allinone_section/general/besttitle';
    const BEST_PRODUCT_COUNT  = 'mage2_allinone_section/general/bestproductcount';

    const DEFAULT_COUNT = 16;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $config_path
     * @return mixed
     */
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue($config_path, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return boolean
     */
    public function getFeatureEnable()
    {
        return $this->getConfig(self::FEATURE_ENABLE_SETTING);
    }

    /**
     * @return int|mixed
     */
    public function getFeatureProductCount()
    {
        return $this->getConfig(self::FEATURE_PRODUCT_COUNT) ?
            $this->getConfig(self::FEATURE_PRODUCT_COUNT) :
            self::DEFAULT_COUNT;
    }

    /**
     * @return mixed|string
     */
    public function getFeatureBlockTitle()
    {
        return $this->getConfig(self::FEATURE_BLOCK_TITLE) ?
            $this->getConfig(self::FEATURE_BLOCK_TITLE) :
            "Feature Product";
    }

    /**
     * @return mixed
     */
    public function getNewEnable()
    {
        return $this->getConfig(self::NEW_ENABLE_SETTING);
    }

    /**
     * @return int|mixed
     */
    public function getNewProductCount()
    {
        return $this->getConfig(self::NEW_PRODUCT_COUNT) ?
            $this->getConfig(self::NEW_PRODUCT_COUNT) :
            self::DEFAULT_COUNT;
    }

    /**
     * @return mixed|string
     */
    public function getNewBlockTitle()
    {
        return $this->getConfig(self::NEW_BLOCK_TITLE) ?
            $this->getConfig(self::NEW_BLOCK_TITLE) :
            "New Product";
    }

    /**
     * @return mixed
     */
    public function getMostEnable()
    {
        return $this->getConfig(self::MOST_ENABLE_SETTING);
    }

    /**
     * @return int|mixed
     */
    public function getMostProductCount()
    {
        return $this->getConfig(self::MOST_PRODUCT_COUNT) ?
            $this->getConfig(self::MOST_PRODUCT_COUNT) :
            self::DEFAULT_COUNT;
    }

    /**
     * @return mixed|string
     */
    public function getMostBlockTitle()
    {
        return $this->getConfig(self::MOST_BLOCK_TITLE) ?
            $this->getConfig(self::MOST_BLOCK_TITLE) :
            "Most Viewable Product";
    }

    /**
     * @return mixed
     */
    public function getBestEnable()
    {
        return $this->getConfig(self::BEST_ENABLE_SETTING);
    }

    /**
     * @return int|mixed
     */
    public function getBestProductCount()
    {
        return $this->getConfig(self::BEST_PRODUCT_COUNT) ?
            $this->getConfig(self::BEST_PRODUCT_COUNT) :
            self::DEFAULT_COUNT;
    }

    /**
     * @return mixed|string
     */
    public function getBestBlockTitle()
    {
        return $this->getConfig(self::BEST_BLOCK_TITLE) ?
            $this->getConfig(self::BEST_BLOCK_TITLE) :
            "Bestseller Product";
    }
}
