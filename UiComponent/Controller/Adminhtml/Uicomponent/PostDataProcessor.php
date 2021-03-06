<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Scommerce\UiComponent\Controller\Adminhtml\Uicomponent;

use Magento\Framework\Message\ManagerInterface;

/**
 * Controller helper for user input.
 */
class PostDataProcessor
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;


    /**
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'name' => __('Page Title'),
            'date_of_birth' => __('Date Of Birth'),
            'is_active' => __('Active')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}
