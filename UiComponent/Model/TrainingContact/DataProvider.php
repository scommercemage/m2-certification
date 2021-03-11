<?php

namespace Scommerce\UiComponent\Model\TrainingContact;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
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
    public const UPLOAD_PATH = 'contact/images/';

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
     * @var Mime
     */
    private $mime;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    private $_mediaDirectory;
    /**
     * @var Filesystem
     */
    private $fs;
    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @param string $name
     * @param Mime $mime
     * @param Filesystem $fs
     * @param ContextInterface $context
     * @param StoreManagerInterface $storeManager
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
        Mime $mime,
        Filesystem $fs,
        ContextInterface $context,
        StoreManagerInterface $storeManager,
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
        $this->_mediaDirectory = $fs->getDirectoryRead(DirectoryList::MEDIA);

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
        $this->meta = $this->prepareMeta($this->meta);
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->mime = $mime;
        $this->storeManager = $storeManager;
        $this->fs = $fs;
        $this->context = $context;
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

        $trainingContactId = $this->context->getRequestParam($this->getRequestFieldName(), null);
        $items = $this->collection->addFieldToFilter('id', $trainingContactId)->getItems();

        /** @var $trainingContact TrainingContact */
        $currentStore = $this->storeManager->getStore();

        foreach ($items as $trainingContact) {
            $this->loadedData[$trainingContact->getId()] = $trainingContact->getData();
        }

        if (!empty($this->loadedData) && $this->loadedData[$trainingContactId]['image']) {
            $media_url = $currentStore->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

            $image_name = $this->loadedData[$trainingContactId]['image'];
            unset($this->loadedData[$trainingContactId]['image']);
            $this->loadedData[$trainingContactId]['image'][0]['name'] = $image_name;
            $this->loadedData[$trainingContactId]['image'][0]['file'] = $image_name;
            $this->loadedData[$trainingContactId]['image'][0]['url'] = $media_url . $this->getRelativeFileName($image_name);
            $this->loadedData[$trainingContactId]['image'][0]['size'] = $this->getFileSize($image_name);
            $this->loadedData[$trainingContactId]['image'][0]['type'] =
                $this->mime->getMimeType($this->_mediaDirectory->getAbsolutePath($this->getRelativeFileName($image_name)));
        }

        return $this->loadedData;
    }

    protected function getRelativeFileName(string $imageName): string
    {
        return self::UPLOAD_PATH . $imageName;
    }

    protected function getFileSize(string $fileName): ?int
    {
        try {
            $fullFileName = sprintf('%s%s', self::UPLOAD_PATH, $fileName);

            $statResults = $this->_mediaDirectory->stat($fullFileName);
            return is_array($statResults) ? $statResults['size'] : null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function getMeta()
    {
        return parent::getMeta();
    }
}
