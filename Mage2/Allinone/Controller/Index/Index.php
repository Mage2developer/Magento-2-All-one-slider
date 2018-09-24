<?php

namespace Mage2\Allinone\Controller\Index;

class Index extends \Mage2\Allinone\Controller\Index
{

    public function execute()
    {
       $resultPage = $this->resultPageFactory->create();
       return $resultPage;
    }
}