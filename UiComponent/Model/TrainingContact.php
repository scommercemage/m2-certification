<?php

namespace Scommerce\UiComponent\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Scommerce\UiComponent\Api\Data\TrainingContactInterface;
use Scommerce\UiComponent\Model\ResourceModel\TrainingContact\Collection;

/**
 * @method ResourceModel\TrainingContact getResource()
 * @method Collection getCollection()
 */
class TrainingContact extends AbstractModel implements TrainingContactInterface, IdentityInterface
{
    const CACHE_TAG = 'scommerce_uicomponent_trainingcontact';

    /**
     * @var string
     */
    protected $_cacheTag = 'scommerce_uicomponent_trainingcontact';

    /**
     * @var string
     */
    protected $_eventPrefix = 'scommerce_uicomponent_trainingcontact';

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Scommerce\UiComponent\Model\ResourceModel\TrainingContact');
    }
}
