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

namespace Mage2\Allinone\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Mage2\Allinone\Model\Collection;

/**
 * Class ProductCollection
 */
class ProductCollection extends Template
{
    /**
     * @var PostHelper
     */
    protected $postDataHelper;

    /**
     * @var ListProduct
     */
    protected $productCollection;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * ProductCollection constructor.
     *
     * @param Template\Context $context
     * @param PostHelper $postDataHelper
     * @param ListProduct $productCollection
     * @param ProductFactory $productFactory
     * @param Image $image
     * @param Collection $collection
     */
    public function __construct(
        Template\Context $context,
        PostHelper $postDataHelper,
        ListProduct $productCollection,
        ProductFactory $productFactory,
        Image $image,
        Collection $collection
    ) {
        $this->postDataHelper    = $postDataHelper;
        $this->productCollection = $productCollection;
        $this->productFactory = $productFactory;
        $this->image = $image;
        $this->collection = $collection;
        parent::__construct($context);
    }

    /**
     * Get block enabled config value from the type of block
     *
     * @param $type
     * @return boolean|string|mixed
     */
    public function getBlockEnabled($type) {
        return $this->collection->getEnabled($type);
    }

    /**
     * Get block title config value from the type of block
     *
     * @param $type
     * @return \Magento\Framework\Phrase|mixed
     */
    public function getBlockTitle($type) {
        return $this->collection->getTitle($type);
    }

    /**
     * Get product collection from the type of block
     *
     * @param $type
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection|\Magento\Reports\Model\ResourceModel\Product\Collection|string
     */
    public function getBlockProductCollection($type) {
        $productCollection = '';
        switch ($type) {
            case Collection::FEATURED:
                $productCollection = $this->collection->getFeaturedProducts();
                break;
            case Collection::NEW:
                $productCollection = $this->collection->getNewProducts();
                break;
            case Collection::MOSTVIEWED:
                $productCollection = $this->collection->getMostViewedProducts();
                break;
            case Collection::BESTSELLER:
                $productCollection = $this->collection->getBestsellerProducts();
                break;
        }
        return $productCollection;
    }

    /**
     * Get product object by product identifier
     *
     * @param $id
     * @return \Magento\Catalog\Model\Product
     */
    public function getProductById($id) {
        return $this->productFactory->create()->load($id);
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
     * Get product price
     *
     * @param $product
     * @return string
     */
    public function getPrice($product) {
        return $this->productCollection->getProductPrice($product);
    }

    /**
     * Get add to cart button url
     *
     * @param $product
     * @return string
     */
    public function getAddToCartButtonUrl($product) {
        return $this->productCollection->getAddToCartUrl($product);
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
            $this->productCollection->getAddToCartUrl($product),
            ['product' => $product->getEntityId()]
        );
    }
}
