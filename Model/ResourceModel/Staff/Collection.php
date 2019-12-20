<?php


namespace Magenest\Staff\Model\ResourceModel\Staff;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init('Magenest\Staff\Model\Staff',
            'Magenest\Staff\Model\ResourceModel\Staff');
    }
}