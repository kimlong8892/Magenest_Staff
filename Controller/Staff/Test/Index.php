<?php


namespace Magenest\Staff\Controller\Staff\Test;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;
    protected $modelStaffFactory;
    protected $json;
    protected $serialize;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magenest\Staff\Model\StaffFactory $modelStaffFactory,
        JsonFactory $json,
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


        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}