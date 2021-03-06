<?php

namespace Scommerce\UiComponent\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Scommerce\UiComponent\Api\Data\TrainingContactInterface;
use Scommerce\UiComponent\Api\Data\TrainingContactInterfaceFactory;
use Scommerce\UiComponent\Api\Data\TrainingContactSearchResultsInterface;
use Scommerce\UiComponent\Api\Data\TrainingContactSearchResultsInterfaceFactory;
use Scommerce\UiComponent\Api\TrainingContactRepositoryInterface;
use Scommerce\UiComponent\Model\ResourceModel\TrainingContact as ResourceTrainingContact;
use Scommerce\UiComponent\Model\ResourceModel\TrainingContact\Collection;
use Scommerce\UiComponent\Model\ResourceModel\TrainingContact\CollectionFactory as TrainingContactCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class TrainingContactRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TrainingContactRepository implements TrainingContactRepositoryInterface
{
    /**
     * @var ResourceTrainingContact
     */
    protected $resource;

    /**
     * @var TrainingContactFactory
     */
    protected $trainingContactFactory;

    /**
     * @var TrainingContactCollectionFactory
     */
    protected $trainingContactCollectionFactory;

    /**
     * @var TrainingContactSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var TrainingContactInterfaceFactory
     */
    protected $dataTrainingContactFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceTrainingContact $resource
     * @param TrainingContactFactory $trainingContactFactory
     * @param TrainingContactInterfaceFactory $dataTrainingContactFactory
     * @param TrainingContactCollectionFactory $trainingContactCollectionFactory
     * @param TrainingContactSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceTrainingContact $resource,
        TrainingContactFactory $trainingContactFactory,
        TrainingContactInterfaceFactory $dataTrainingContactFactory,
        TrainingContactCollectionFactory $trainingContactCollectionFactory,
        TrainingContactSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->trainingContactFactory = $trainingContactFactory;
        $this->trainingContactCollectionFactory = $trainingContactCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTrainingContactFactory = $dataTrainingContactFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save TrainingContact data
     *
     * @param TrainingContact $trainingContact
     * @return TrainingContact
     * @throws CouldNotSaveException
     */
    public function save(TrainingContactInterface $trainingContact)
    {
        if (empty($trainingContact->getStoreId())) {
            $trainingContact->setStoreId($this->storeManager->getStore()->getId());
        }

        try {
            $this->resource->save($trainingContact);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $trainingContact;
    }

    /**
     * Load TrainingContact data by given TrainingContact Identity
     *
     * @param string $trainingContactId
     * @return TrainingContact
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($trainingContactId)
    {
        $trainingContact = $this->trainingContactFactory->create();
        $this->resource->load($trainingContact, $trainingContactId);
        if (!$trainingContact->getId()) {
            throw new NoSuchEntityException(__('The CMS TrainingContact with the "%1" ID doesn\'t exist.', $trainingContactId));
        }
        return $trainingContact;
    }

    /**
     * Load TrainingContact data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return TrainingContactSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        /** @var Collection $collection */
        $collection = $this->trainingContactCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var TrainingContactSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete TrainingContact
     *
     * @param TrainingContactInterface $trainingContact
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TrainingContactInterface $trainingContact)
    {
        try {
            $this->resource->delete($trainingContact);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete TrainingContact by given TrainingContact Identity
     *
     * @param string $trainingContactId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($trainingContactId)
    {
        return $this->delete($this->getById($trainingContactId));
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 102.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Scommerce\UiComponent\Model\Api\SearchCriteria\TrainingContactCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}
