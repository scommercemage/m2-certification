<?php

namespace Scommerce\UiComponent\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class TrainingContact
 * @package Scommerce\UiComponent\Model\ResourceModel
 */
class TrainingContact extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('training_contact', 'id');
    }
}
