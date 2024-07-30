<?php

namespace Conceptive\AdvanceSearch\Controller\Search;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Result implements HttpPostActionInterface
{
    protected $resultPageFactory;
    protected $resultJsonFactory;
    protected $url;
    protected $request;
    protected $redirect;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->redirect = $context->getRedirect();
        $this->url = $context->getUrl();
        $this->request = $context->getRequest();
    }

    public function execute()
    {
        $params = $this->request->getParams();
        $attribute = $params['ccsearch'] ?? null;
        $priceFrom = $params['price_from'] ?? null;
        $priceTo = $params['price_to'] ?? null;

        $redirectUrl = $this->redirect->getRedirectUrl();

        $resultPage = $this->resultPageFactory->create();

        $resultContent = $resultPage->getLayout()
            ->createBlock('Conceptive\AdvanceSearch\Block\ListProduct')
            ->setTemplate('Conceptive_AdvanceSearch::result.phtml')
            ->setData('attribute', $attribute)
            ->setData('price_from', $priceFrom)
            ->setData('price_to', $priceTo)
            ->setData('redirect_url', $redirectUrl)
            ->toHtml();

        $result = $this->resultJsonFactory->create();
        $result->setData(['output' => $resultContent]);

        return $result;
    }
}
