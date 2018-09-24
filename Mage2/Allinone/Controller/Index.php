<?php

namespace Mage2\Allinone\Controller;

abstract class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,

        array $data = []
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context , $data);
    }
}
?>