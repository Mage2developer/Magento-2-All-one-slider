<?php
/**
 * Product Name: Mage2 All in one
 * Module Name: Mage2_Allinone
 * Created By: Yogesh Shishangiya
 */

declare(strict_types=1);

namespace Mage2\Allinone\Controller\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

/**
 * Class Index
 */
class Index extends \Mage2\Allinone\Controller\Index
{
    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
