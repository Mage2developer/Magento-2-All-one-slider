<?php
/**
 * Product Name: Mage2 All in one
 * Module Name: Mage2_Allinone
 * Created By: Yogesh Shishangiya
 */

declare(strict_types=1);

namespace Mage2\Allinone\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Helper\Image;
use Mage2\Allinone\Model\Config;
use Mage2\Allinone\Model\Collection;

/**
 * Class Index
 */
class Index extends ListProduct
{
    /**
     * @var Collection
     */
    protected $productCollection;

    /**
     * @var ProductFactory
     */
    protected $productloader;

    /**
     * @var AbstractProduct
     */
    protected $abstractProduct;

    /**
     * @var PostHelper
     */
    protected $postDataHelper;

    /**
     * @var Config
     */
    protected $extConfig;

    /**
     * @var Image
     */
    protected $image;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Data $urlHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ProductFactory $productloader
     * @param AbstractProduct $abstractProduct
     * @param Config $extConfig
     * @param Collection $productCollection
     * @param Image $image
     */
    public function __construct(
        Context $context,
        PostHelper $postDataHelper,
        Data $urlHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        ProductFactory $productloader,
        AbstractProduct $abstractProduct,
        Config $extConfig,
        Collection $productCollection,
        Image $image
    ) {
        $this->productCollection = $productCollection;
        $this->postDataHelper    = $postDataHelper;
        $this->urlHelper         = $urlHelper;
        $this->catalogLayer      = $layerResolver->get();
        $this->extConfig         = $extConfig;
        $this->productloader     = $productloader;
        $this->abstractProduct   = $abstractProduct;
        $this->image             = $image;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper);
    }

    /**
     * Retrieve featured products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function featureProductCollection()
    {
        return $this->productCollection->getFeatureProducts();
    }

    /**
     * Retrieve featured product block title
     *
     * @return mixed|string
     */
    public function featureBlockTitle()
    {
        return $this->extConfig->getFeatureBlockTitle();
    }

    /**
     * Retrieve new products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function newProductCollection()
    {
        return $this->productCollection->getNewProducts();
    }

    /**Retrieve new product block title
     *
     * @return mixed|string
     */
    public function newBlockTitle()
    {
        return $this->extConfig->getNewBlockTitle();
    }

    /**
     * Retrieve best seller products collection
     *
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function bestSellerCollection()
    {
        return $this->productCollection->getBestsellerProducts();
    }

    /**
     * Retrieve best seller product block title
     *
     * @return mixed|string
     */
    public function bestBlockTitle()
    {
        return $this->extConfig->getBestBlockTitle();
    }

    /**
     * Retrieve most viewed products collection
     *
     * @return \Magento\Framework\DataObject[]
     */
    public function mostViewedCollection()
    {
        return $this->productCollection->getMostViewedProducts();
    }

    /**
     * Retrieve most viewed products block title
     *
     * @return mixed|string
     */
    public function mostBlockTitle()
    {
        return $this->extConfig->getMostBlockTitle();
    }

    /**
     * Get featured products block enabled or not
     *
     * @return boolean
     */
    public function featureStatus()
    {
        return $this->extConfig->getFeatureEnable();
    }

    /**
     * Get new products block enabled or not
     *
     * @return boolean
     */
    public function newStatus()
    {
        return $this->extConfig->getNewEnable();
    }

    /**
     * Get most viewed products block enabled or not
     *
     * @return boolean
     */
    public function mostStatus()
    {
        return $this->extConfig->getMostEnable();
    }

    /**
     * Get best seller products block enabled or not
     *
     * @return boolean
     */
    public function bestStatus()
    {
        return $this->extConfig->getBestEnable();
    }

    /**
     * Get product by identifier
     *
     * @param $id
     * @return \Magento\Catalog\Model\Product
     */
    public function getProductById($id)
    {
        return $this->productloader->create()->load($id);
    }

    /**
     * Get product price from product object
     *
     * @param $product
     * @return string
     */
    public function getPrice($product)
    {
        return $this->abstractProduct->getProductPrice($product);
    }

    /**
     * Get product image from product object
     *
     * @param $product
     * @return string
     */
    public function getProductImage($product)
    {
        return $this->abstractProduct->getImage($product, 'latest_collection_list')->getImageUrl();
    }

    /**
     * Get product image url
     *
     * @param $product
     * @return string
     */
    public function getProductImageUrl($product)
    {
        return $this->image->init($product, 'product_page_image_large')
            ->constrainOnly(false)
            ->keepAspectRatio(true)
            ->keepFrame(true)
            ->resize(256, 329)
            ->getUrl();
    }

    /**
     * Get add to cart button post data
     *
     * @param $product
     * @return string
     */
    public function getAddToCartButtonPostData($product)
    {
        return $this->postDataHelper->getPostData(
            $this->getAddToCartUrl($product),
            ['product' => $product->getEntityId()]
        );
    }
}
