<?php

namespace Scommerce\UiComponent\Api;

use Scommerce\UiComponent\Api\Data\TrainingContactInterface;
use Scommerce\UiComponent\Api\Data\TrainingContactSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Training Contact  CRUD interface.
 * @api
 * @since 100.0.2
 */
interface TrainingContactRepositoryInterface
{
    /**
     * Save page.
     *
     * @param TrainingContactInterface $trainingContact
     * @return TrainingContactInterface
     * @throws LocalizedException
     */
    public function save(TrainingContactInterface $trainingContact);

    /**
     * Retrieve page.
     *
     * @param int $Id
     * @return TrainingContactInterface
     * @throws LocalizedException
     */
    public function getById($Id);

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return TrainingContactSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete page.
     *
     * @param TrainingContactInterface $trainingContact
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(TrainingContactInterface $trainingContact);

    /**
     * Delete page by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($id);
}
