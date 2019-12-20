<?php


namespace Magenest\Staff\Controller\Staff;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Update extends Action
{
    protected $resultPageFactory;
    protected $modelStaffFactory;
    protected $customerSession;
    protected $_customerRepositoryInterface;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magenest\Staff\Model\StaffFactory $modelStaffFactory,
        SessionFactory $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->modelStaffFactory = $modelStaffFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context);
    }

    public function execute()
    {

        if(isset($this->_request->getParams()['id']))
        {
            $id = $this->_request->getParam('id');
            $modelStaff = $this->modelStaffFactory->create()->load($id);
            $modelStaff->setType($this->_request->getParam('type'));
            $customerId = $this->customerSession->create()->getId();


            $customer = $this->_customerRepositoryInterface->getById($customerId);
            $customer->setCustomAttribute('staff_type', $this->_request->getParam('type'));
            $customer = $this->_customerRepositoryInterface->save($customer);


            $modelStaff->setNickName($this->_request->getParam('name'));
            $modelStaff->save();
        }


        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}