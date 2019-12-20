<?php
namespace Magenest\Staff\Block\Staff;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;

class ShowDefault extends Template
{
    protected $modelStaffFactory;
    protected $_customerSession;
    public function __construct
    (
        \Magenest\Staff\Model\StaffFactory $modelStaffFactory,
        SessionFactory $customerSession,
        Template\Context $context, array $data = []
    )
    {
        $this->modelStaffFactory = $modelStaffFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getStaff()
    {
        $customer = $this->_customerSession->create();
        $collection = $this->modelStaffFactory->create()->getCollection()->addFieldToFilter('customer_id', $customer->getId())->getFirstItem();
        return $collection->getData();
    }


}