<?php


namespace Magenest\Staff\Controller\Adminhtml\Staff;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class ChangeStatus extends Action
{
    protected $resultPageFactory;
    protected $modelStaff;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magenest\Staff\Model\StaffFactory $modelStaff
    ) {
        $this->modelStaff = $modelStaff;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $rowId = $this->_request->getParam('selected');
        $status = $this->_request->getParam('status');
        $modelStaff = $this->modelStaff->create();
        forEach($rowId as $id)
        {
            $modelStaff->load($id);
            $modelStaff->setStatus($status);
            $modelStaff->save();
        }
        return $this->_redirect('staff/staff/show');
    }
}