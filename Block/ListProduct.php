<?php

namespace Conceptive\AdvanceSearch\Block;

use Magento\Catalog\Model\CategoryFactory;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class ListProduct extends \Magento\Catalog\Block\Product\AbstractProduct
{

    /**
     * @var CategoryFactory
     */
    protected $_categoryFactory;

    protected $_productCollectionFactory;

    protected $productFactory;

    /**
     * CategoryProducts constructor.
     * @param CategoryFactory $categoryFactory
     * @param array $data
     */

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        CategoryFactory $categoryFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Block\Product\ListProduct $listProductBlock,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        $this->productRepository = $productRepository;
        $this->_categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
        $this->listProductBlock = $listProductBlock;
        parent::__construct($context, $data);
    }

    /**
     * @param $categoryId
     * @return \Magento\Catalog\Model\Category
     */

    public function getProductCollection($attributeId = null)
    {
        $attributeColl = $this->getAttribute();
        $priceFrom = $this->getPriceFrom();
        $priceTo = $this->getPriceTo();

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        if (is_array($attributeColl)) {
            foreach ($attributeColl as $attrCode => $attrOptions) {
                $collection->addAttributeToFilter($attrCode, ['in' => $attrOptions]);
            }
        }
        $collection->addFieldToFilter('price', array('from' => $priceFrom, 'to' => $priceTo));
        $collection->addAttributeToSort('price', 'ASC');
        $collection->setPageSize(50);
        return $collection;
    }

    public function getItemImage($productId)
    {
        try {
            $_product = $this->productRepository->getById($productId);
        } catch (\Exception $e) {
            return 'product not found';
        }
        $image_url = $this->imageHelper->init($_product, 'product_base_image')->getUrl();
        return $image_url;
    }

    public function getAddToCartPostParams($product)
    {
        return $this->listProductBlock->getAddToCartPostParams($product);
    }

    public function getAttrOptionLabel($attrCode = null, $optionId = null)
    {
        $collection = $this->_productCollectionFactory->create();
        $attribute = $collection->getResource()->getAttribute($attrCode);
        if ($attribute->usesSource()) {
            $optionText = $attribute->getSource()->getOptionText($optionId);
        }
        return $optionText;
    }

    public function getAttrLabel($attrCode)
    {
        $product = $this->productFactory->create();
        $attribute = $product->getResource()->getAttribute($attrCode);
        if ($attribute->usesSource()) {
            $attributeLabel = $attribute->getFrontendLabel();
        }
        return $attributeLabel;
    }
}
