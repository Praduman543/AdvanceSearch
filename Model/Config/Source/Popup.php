<?php
/**
 * My own options
 *
 */
namespace Conceptive\AdvanceSearch\Model\Config\Source;
class Popup implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('Popup')],
            ['value' => '0', 'label' => __('Page')]
        ];
    }
}