<?php

namespace Scommerce\UiComponent\Model\TrainingContact;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Scommerce\UiComponent\Model\TrainingContact;
use Scommerce\UiComponent\Model\ResourceModel\TrainingContact\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;

/**
 * Class DataProvider
 */
class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var AuthorizationInterface
     */
    private $auth;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $trainingContactCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     * @param AuthorizationInterface|null $auth
     * @param RequestInterface|null $request
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $trainingContactCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null,
        ?RequestInterface $request = null
    ) {
        $this->collection = $trainingContactCollectionFactory->create();
        $this->collectionFactory = $trainingContactCollectionFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
        $this->meta = $this->prepareMeta($this->meta);
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
    }

    /**
     * Find requested page.
     *
     * @return Page|null
     */
    private function findCurrentPage(): ?Page
    {
        if ($this->getRequestFieldName() && ($trainingContactId = (int)$this->request->getParam($this->getRequestFieldName()))) {
            //Loading data for the collection.
            $this->getData();
            return $this->collection->getItemById($trainingContactId);
        }

        return null;
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $this->collection = $this->collectionFactory->create();
        $items = $this->collection->getItems();
        /** @var $trainingContact TrainingContact */
        foreach ($items as $trainingContact) {
            $this->loadedData[$trainingContact->getId()] = $trainingContact->getData();
        }

        return $this->loadedData;
    }

    /**
     * @inheritDoc
     */
    public function getMeta()
    {
        return parent::getMeta();
    }
}
