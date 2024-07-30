<?php

namespace Conceptive\AdvanceSearch\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Index implements HttpGetActionInterface
{
    protected $resultFactory;

    public function __construct(
        Context $context
    ) {
        $this->resultFactory = $context->getResultFactory();
    }

    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
