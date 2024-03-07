<?php
/**
 * My own options
 *
 */
namespace Conceptive\AdvanceSearch\Model\Config\Source;
class Show implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'header', 'label' => __('Footer')],
            ['value' => 'footer', 'label' => __('Header')]
        ];
    }
}