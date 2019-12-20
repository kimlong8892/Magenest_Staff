<?php


namespace Magenest\Staff\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

class SetStaff implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    private $logger;
    protected $_customerRepositoryInterface;
    protected $modelStaff;


    protected $_customerModelFactory;

    public function __construct
    (
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Model\CustomerFactory $customerModelFactory,
        \Magenest\Staff\Model\StaffFactory $modelStaff
    )
    {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->logger = $logger;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_customerModelFactory = $customerModelFactory;
        $this->modelStaff = $modelStaff;
    }

    public function execute(EventObserver $observer)
    {
        $customer = $observer->getCustomerDataObject();
        $idCustomer = $customer->getId();

        $modelStaff = $this->modelStaff->create();
        $row = $modelStaff->getCollection()->addFieldToFilter('customer_id', $idCustomer);

        if($row->count() != 0)
        {
            $modelStaff->load($row->getFirstItem()->getData('id'));
        }
        $modelStaff->setCustomerId($idCustomer);
        $modelStaff->setNickName($customer->getFirstName().' '.$customer->getLastName());
        $type = $this->_customerRepositoryInterface->getById($idCustomer)->getCustomAttribute('staff_type');
        if($type == null)
            $type = 3;
        $modelStaff->setType($type->getValue());
        $modelStaff->setStatus(2);
        $modelStaff->save();
    }
}