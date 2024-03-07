<?php

namespace Conceptive\AdvanceSearch\Block;

use Magento\Framework\View\Element\Template\Context;
use Conceptive\AdvanceSearch\Helper\Data;

class Link extends \Magento\Framework\View\Element\Html\Link
{

    public $helper;

    public function __construct(
        Context $context,
        Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }
    /**
     * Render block HTML.
     *
     * @return string
     */

    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }
        $popup = $this->helper->getGeneralConfig('popup');
        if ($popup == 1) {
            return '<li class="ccsearch popup-modal">' . $this->escapeHtml($this->getLabel()) . '</li>';
        } else {
            return '<li class="footer-search"><a ' . $this->getLinkAttributes() . ' >' . $this->escapeHtml($this->getLabel()) . '</a></li>';
        }
    }
}
