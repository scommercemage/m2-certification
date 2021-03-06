<?php

namespace Scommerce\Tutorial\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;

/**
 * Processes request to tutorial or learning
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        RequestInterface $request
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;

        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
