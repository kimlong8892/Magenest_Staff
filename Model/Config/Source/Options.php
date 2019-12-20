<?php


namespace Magenest\Staff\Model\Config\Source;


class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
            ['label' => __('lv1'), 'value'=>1],
            ['label' => __('lv2'), 'value'=>2],
        ];

        return $this->_options;

    }

}