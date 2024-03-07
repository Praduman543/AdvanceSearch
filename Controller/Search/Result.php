<?php

namespace Conceptive\AdvanceSearch\Controller\Search;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Result extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $resultJsonFactory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }


    public function execute()
    {
        // echo '<pre>';
        // print_r($this->getRequest()->getParams());exit;
        $params = $this->getRequest()->getParams();
        $attribute = (isset($params['ccsearch']))? $params['ccsearch'] : null;
        $priceFrom = (!empty($params['price_from']))? $params['price_from'] : null;
        $priceTo = (!empty($params['price_to']))? $params['price_to'] : null;

        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();


        $block = $resultPage->getLayout()
                ->createBlock('Conceptive\AdvanceSearch\Block\ListProduct')
                ->setTemplate('Conceptive_AdvanceSearch::result.phtml')
                ->setData('attribute',$attribute)
                ->setData('price_from',$priceFrom)
                ->setData('price_to',$priceTo)
                ->toHtml();

        $result->setData(['output' => $block]);
        // if (empty($numone) && empty($attributeId) && empty($priceFrom) && empty($priceTo)) {
        //     $resultRedirect = $this->resultRedirectFactory->create();
        //     $resultRedirect->setPath('checkout/cart/index');
        //     return $resultRedirect;
        // } else {
        //     return $result;
        // }
        return $result;
    }
}