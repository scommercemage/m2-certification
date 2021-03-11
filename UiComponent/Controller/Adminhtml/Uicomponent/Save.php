<?php

namespace Scommerce\UiComponent\Controller\Adminhtml\Uicomponent;

use Magento\Backend\Model\View\Result\Redirect;
use Scommerce\UiComponent\Api\Data\TrainingContactInterface;
use Scommerce\UiComponent\Api\TrainingContactRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action;
use Scommerce\UiComponent\Model\TrainingContact;
use Scommerce\UiComponent\Model\TrainingContactFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save training contact action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var TrainingContactFactory
     */
    private $trainingContactFactory;

    /**
     * @var TrainingContactRepositoryInterface
     */
    private $trainingContactRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param TrainingContactFactory|null $trainingContactFactory
     * @param TrainingContactRepositoryInterface|null $trainingContactRepository
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        TrainingContactFactory $trainingContactFactory = null,
        TrainingContactRepositoryInterface $trainingContactRepository = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->trainingContactFactory = $trainingContactFactory ?: ObjectManager::getInstance()->get(TrainingContactFactory::class);
        $this->trainingContactRepository = $trainingContactRepository
            ?: ObjectManager::getInstance()->get(TrainingContactRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if ($this->dataProcessor->validateRequireEntry($data)) {
                if (isset($data['is_active']) && $data['is_active'] === 'true') {
                    $data['is_active'] = true;
                }


                if (empty($data['id'])) {
                    $data['id'] = null;
                }

                /** @var TrainingContact $model */
                $model = $this->trainingContactFactory->create();

                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    try {
                        $model = $this->trainingContactRepository->getById($id);
                    } catch (LocalizedException $e) {
                        $this->messageManager->addErrorMessage(__('This training contact no longer exists.'));
                        return $resultRedirect->setPath('*/*/');
                    }
                }

                // save image
                if (isset($data["image"])) {
                    $img = $data["image"][0];
                    $data["image"] = $img["name"];
                }

                $model->setData($data);

                try {
                    $this->_eventManager->dispatch(
                        'training_contact_prepare_save',
                        ['training_contact' => $model, 'request' => $this->getRequest()]
                    );

                    $this->trainingContactRepository->save($model);
                    $this->messageManager->addSuccessMessage(__('You saved the training contact.'));
                    return $this->processResultRedirect($model, $resultRedirect, $data);
                } catch (LocalizedException $e) {
                    $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
                } catch (\Throwable $e) {
                    $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the page.'));
                }

                $this->dataPersistor->set('training_contact', $data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
            else {
                $this->dataPersistor->set('training_contact', $data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        return $resultRedirect->setPath('*/*/edit');
    }

    /**
     * Process result redirect
     *
     * @param TrainingContactInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newPage = $this->trainingContactFactory->create(['data' => $data]);
            $newPage->setId(null);
            $identifier = $model->getIdentifier() . '-' . uniqid();
            $newPage->setIdentifier($identifier);
            $newPage->setIsActive(false);
            $this->trainingContactRepository->save($newPage);
            $this->messageManager->addSuccessMessage(__('You duplicated the training contact.'));
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $newPage->getId(),
                    '_current' => true
                ]
            );
        }
        $this->dataPersistor->clear('training_contact');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
