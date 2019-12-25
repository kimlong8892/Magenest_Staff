<?php


namespace Magenest\Staff\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

class SetStaff implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    private $logger;
    protected $modelStaff;
    protected $collectionStaffFactory;




    public function __construct
    (
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magenest\Staff\Model\StaffFactory $modelStaff,
        \Magenest\Staff\Model\ResourceModel\Staff\CollectionFactory $collectionStaffFactory
    )
    {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->logger = $logger;
        $this->modelStaff = $modelStaff;
        $this->collectionStaffFactory = $collectionStaffFactory;
    }

    public function execute(EventObserver $observer)
    {
        $customer = $observer->getCustomerDataObject();
        $customerId = $customer->getId();

        $modelStaff = $this->modelStaff->create();
        $idStaff = $this->collectionStaffFactory->create()->addFieldToFilter('customer_id', $customerId)->getFirstItem()->getData('id');
        if($idStaff != null)
            $modelStaff->load($idStaff);
        $modelStaff->setCustomerId($customerId);
        $modelStaff->setNickName($customer->getFirstName().' '.$customer->getLastName());
        $modelStaff->setType($customer->getCustomAttribute('staff_type')->getValue() ?? 3);
        $modelStaff->setStatus(2);
        try {
            $modelStaff->save();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        /*
        $modelStaff = $this->modelStaff->create();
        $row = $modelStaff->getCollection()->addFieldToFilter('customer_id', $idCustomer);

        if($row->count() != 0)
        {
            $modelStaff->load($row->getFirstItem()->getData('id'));
        }
        $modelStaff->setCustomerId($idCustomer);
        $modelStaff->setNickName($customer->getFirstName().' '.$customer->getLastName());
        $customerInterFace = $this->_customerRepositoryInterface->getById($idCustomer);
        $checkType = $customerInterFace->getCustomAttribute('staff_type');
        if($checkType == null)
        {
            $customerInterFace->setCustomAttribute('staff_type', 3);
            $this->_customerRepositoryInterface->save($customerInterFace);
        }
        else
            $modelStaff->setType($checkType->getValue());
        $modelStaff->setStatus(2);
        $modelStaff->save();
        */
    }
}