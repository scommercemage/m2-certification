<?php

namespace Scommerce\UiComponent\Api\Data;

/**
 * Interface TrainingContactInterface
 * @package Scommerce\UiComponent\Api\Data
 */
interface TrainingContactInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TABLE_NAME                = 'training_contact';

    const ID                        = 'id';
    const NAME                      = 'name';
    const ABOUT_ME                  = 'aboutme';
    const RESUME                    = 'resume';
    const IMAGE                     = 'image';
    const DOB                       = 'date_of_birth';
    const ACTIVE                    = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getIdentities();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getAboutMe();


    /**
     * Get date of birth
     *
     * @return string|null
     */
    public function getDateOfBirth();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return TrainingContactInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string name
     * @return TrainingContactInterface
     */
    public function setName($name);

    /**
     * Set content
     *
     * @param string $aboutme
     * @return TrainingContactInterface
     */
    public function setAboutMe($aboutme);

    /**
     * Set creation time
     *
     * @param string $dateOfBirth
     * @return TrainingContactInterface
     */
    public function setDateOfBirth($dateOfBirth);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return TrainingContactInterface
     */
    public function setIsActive($isActive);
}
