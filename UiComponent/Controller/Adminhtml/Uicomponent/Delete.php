<?php

namespace Scommerce\UiComponent\Controller\Adminhtml\Uicomponent;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Scommerce\UiComponent\Model\TrainingContact;

/**
 * Delete training contact action.
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $name = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(TrainingContact::class);
                $model->load($id);

                $name = $model->getName();
                $model->delete();

                // display success message
                $this->messageManager->addSuccessMessage(__('The training contact has been deleted.'));

                // go to grid
                $this->_eventManager->dispatch('adminhtml_training_contact_on_delete', [
                    'name' => $name,
                    'status' => 'success'
                ]);

                return $resultRedirect->setPath('*/*/grid');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_training_contact_on_delete',
                    ['name' => $name, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a training contact to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/grid');
    }
}
