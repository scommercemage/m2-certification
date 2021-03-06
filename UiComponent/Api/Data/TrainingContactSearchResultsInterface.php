<?php
namespace Scommerce\UiComponent\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 * @since 100.0.2
 */
interface TrainingContactSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get contact list.
     *
     * @return TrainingContactInterface[]
     */
    public function getItems();

    /**
     * Set contact list.
     *
     * @param TrainingContactInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
