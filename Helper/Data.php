<?php

namespace Conceptive\AdvanceSearch\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

	/**
	 * Admin configuration paths
	 *
	 */
	const IS_ENABLED            = 'conceptive/general/enable';

	const XML_PATH_LINK_LOCATION = 'conceptive/general/display_link_location';

	const DISPLAY_ATTRIBUTES    = 'conceptive/general/allowattributesinview';

	const TAB_NAME = 'conceptive/';
	/**
	 * @var \Magento\Framework\App\Config\ScopeConfigInterface
	 */
	protected $scopeConfig;

	/**
	 * Data constructor
	 * @param \Magento\Framework\App\Helper\Context $context
	 * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	 */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		ScopeConfigInterface $scopeConfig
	) {
		$this->scopeConfig = $scopeConfig;
		parent::__construct($context);
	}

	/**
	 * @return $isEnabled
	 */
	public function isEnabled()
	{
		$isEnabled = $this->scopeConfig->getValue(
			self::IS_ENABLED,
			ScopeInterface::SCOPE_STORE
		);

		return $isEnabled;
	}

	public function getDisplayAttributes()
	{
		$displayAttributes =  $this->scopeConfig->getValue(
			self::DISPLAY_ATTRIBUTES,
			ScopeInterface::SCOPE_STORE
		);
		return $displayAttributes;
	}

	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field,
			ScopeInterface::SCOPE_STORE,
			$storeId
		);
	}

	public function getLinkLocation()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_LINK_LOCATION,
            ScopeInterface::SCOPE_STORE
        );
    }

	public function getGeneralConfig($code, $storeId = null)
	{
		return $this->getConfigValue(self::TAB_NAME . 'general/' . $code, $storeId);
	}
}
