<?php


namespace Magenest\Staff\Controller\Staff;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Search extends Action
{
    protected $resultPageFactory;
    protected $modelStaffFactory;
    protected $json;
    protected $serialize;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magenest\Staff\Model\StaffFactory $modelStaffFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Serialize\Serializer\Serialize $serialize
    ) {
        $this->modelStaffFactory = $modelStaffFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->json = $json;
        $this->serialize = $serialize;
        parent::__construct($context);
    }

    public function execute()
    {

        if(isset($this->_request->getParams()['txtSearch']))
        {
            $txt = $this->_request->getParam('txtSearch');
            $modelStaff = $this->modelStaffFactory->create()->getCollection()->addFieldToFilter('nick_name', ['like'=>'%'.$txt.'%']);
            if($modelStaff->count() == 0)
                echo __('No result');
            else
            {
                $rs = '';
                forEach($modelStaff->getData() as $data)
                {
                    $rs .= $data['nick_name'].', ';
                }
                echo substr($rs, 0, strlen($rs)-2);
            }
            return;
        }


        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}