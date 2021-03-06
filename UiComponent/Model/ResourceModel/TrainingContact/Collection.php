<?php

namespace Scommerce\UiComponent\Model\ResourceModel\TrainingContact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Scommerce\UiComponent\Model\ResourceModel\TrainingContact
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Scommerce\UiComponent\Model\TrainingContact', 'Scommerce\UiComponent\Model\ResourceModel\TrainingContact');
    }
}
