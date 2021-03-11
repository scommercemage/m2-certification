<?php


namespace Scommerce\UiComponent\Controller\Adminhtml\Uicomponent;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultInterface;
use Exception;

class Upload extends Action
{

    /**
     * Image uploader
     * @var ImageUploader
     */
    protected $imageUploader;

    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    public function execute(): ResultInterface
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image');
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
