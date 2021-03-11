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

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return parent::getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getImage()
    {
        return parent::getData(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function getAboutMe()
    {
        return parent::getData(self::ABOUT_ME);
    }

    /**
     * @inheritDoc
     */
    public function getDateOfBirth()
    {
        return parent::getData(self::DOB);
    }

    /**
     * @inheritDoc
     */
    public function getIsActive()
    {
        return parent::getData(self::ACTIVE);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * @inheritDoc
     */
    public function setAboutMe($aboutme)
    {
        return $this->setData(self::ABOUT_ME, $aboutme);
    }

    /**
     * @inheritDoc
     */
    public function setDateOfBirth($dateOfBirth)
    {
        return $this->setData(self::DOB, $dateOfBirth);
    }

    /**
     * @inheritDoc
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::ACTIVE, $isActive);
    }
}
