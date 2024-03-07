<?php
namespace Conceptive\AdvanceSearch\Block;

use Conceptive\AdvanceSearch\Helper\Data;

class Index extends \Magento\Framework\View\Element\Template
{        

    protected $helper;
    protected $productFactory;
    protected $_storeManager;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        Data $helper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    )
    {        
        $this->helper = $helper;
        $this->productFactory = $productFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }
    
    /*
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }   

    public function getDisplayAttributes()
    {
        return $this->helper->getDisplayAttributes();
    }
    
    public function getAttrOptIdByLabel($attrCode)
    {
        $product = $this->productFactory->create();
        $attribute = $product->getResource()->getAttribute($attrCode);
        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions();
        }
         return $options;
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

    public function getCurrentCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    } 
}