<?php

namespace Scommerce\UiComponent\Block\Adminhtml\UiComponent\Grid\Renderer\Action;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Url builder class used to compose dynamic urls.
 */
class UrlBuilder
{
    /**
     * @var UrlInterface
     */
    protected $frontendUrlBuilder;

    /**
     * @param UrlInterface $frontendUrlBuilder
     */
    public function __construct(UrlInterface $frontendUrlBuilder)
    {
        $this->frontendUrlBuilder = $frontendUrlBuilder;
    }

    /**
     * Get action url
     *
     * @param string $routePath
     * @param string $scope
     * @param string $store
     * @return string
     */
    public function getUrl($routePath, $scope, $store)
    {
        if ($scope) {
            $this->frontendUrlBuilder->setScope($scope);
            $href = $this->frontendUrlBuilder->getUrl(
                $routePath,
                [
                    '_current' => false,
                    '_nosid' => true,
                    '_query' => [StoreManagerInterface::PARAM_NAME => $store]
                ]
            );
        } else {
            $href = $this->frontendUrlBuilder->getUrl(
                $routePath,
                [
                    '_current' => false,
                    '_nosid' => true
                ]
            );
        }

        return $href;
    }
}
