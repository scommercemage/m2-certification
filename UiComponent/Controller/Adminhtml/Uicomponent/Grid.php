<?php

namespace Scommerce\UiComponent\Controller\Adminhtml\Uicomponent;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Grid
 * @package Scommerce\UiComponent\Controller\Adminhtml\Uicomponent
 */
class Grid extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * Grid constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->prepend('UiComponent Grid');
        return $page;
    }
}
