<?php
/**
 * Product Name: Mage2 All in one
 * Module Name: Mage2_Allinone
 * Created By: Yogesh Shishangiya
 */

declare(strict_types=1);

namespace Mage2\Allinone\Controller;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
abstract class Index extends Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
}
