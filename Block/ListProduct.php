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

    public function getProductCollection()
    {
        $conditions = [];
        $attributeColl = $this->getAttribute();
        $priceFrom = $this->getPriceFrom();
        $priceTo = $this->getPriceTo();

        if (empty($attributeColl) && empty($priceFrom) && empty($priceTo)) {
            // Return an empty collection if no conditions are present
            return $this->_productCollectionFactory->create()->addAttributeToFilter('entity_id', ['in' => []]);
        }

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('visibility', ['neq' => \Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE]);
        
        if (is_array($attributeColl) && !empty($attributeColl)) {
            foreach ($attributeColl as $attrCode => $attrOptions) {
                $conditions[] = ['attribute' => $attrCode, 'in' => $attrOptions];
            }
            $collection->addAttributeToFilter($conditions);
        }
        
        if (!empty($priceFrom) || !empty($priceTo)) {
            $collection->addFieldToFilter('price', ['from' => $priceFrom, 'to' => $priceTo]);
        }

        $collection->addAttributeToSort('price', 'ASC');
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
