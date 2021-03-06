<?php
declare(strict_types=1);

namespace Scommerce\UiComponent\Model;

use Scommerce\UiComponent\Api\Data\TrainingContactSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Page search results.
 */
class TrainingContactSearchResults extends SearchResults implements TrainingContactSearchResultsInterface
{
}
