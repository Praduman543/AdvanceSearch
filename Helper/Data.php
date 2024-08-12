<?php

namespace Conceptive\AdvanceSearch\Helper;

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
	 * Data constructor
	 * @param \Magento\Framework\App\Helper\Context $context
	 */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context
	) {
		parent::__construct($context);
	}

	public function isEnabled()
	{
		$isEnabled = $this->getConfigValue(
			self::IS_ENABLED
		);

		return $isEnabled;
	}


	public function getConfigValue($path, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$path,
			ScopeInterface::SCOPE_STORE,
			$storeId
		);
	}

	public function getDisplayAttributes()
	{
		$displayAttributes =  $this->getConfigValue(
			self::DISPLAY_ATTRIBUTES,
		);
		return $displayAttributes;
	}

	public function getLinkLocation()
    {
        return $this->getConfigValue(
            self::XML_PATH_LINK_LOCATION
        );
    }

	public function getGeneralConfig($field)
	{
		return $this->getConfigValue(self::TAB_NAME . 'general/' . $field);
	}
}
