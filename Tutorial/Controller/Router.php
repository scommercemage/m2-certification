<?php
declare(strict_types=1);

namespace Scommerce\Tutorial\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Router\ActionList;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\Route\ConfigInterface;

/**
 * Class Router
 */
class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var ConfigInterface
     */
    private $routeConfig;

     /**
      * @var ActionList
      */
    private $actionList;

    /**
     * Router constructor.
     *
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     * @param ConfigInterface $routeConfig
     * @param ActionList $actionList
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ConfigInterface $routeConfig,
        ActionList $actionList
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->routeConfig = $routeConfig;
        $this->actionList = $actionList;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $identifier = trim($request->getPathInfo(), '/');
        if (strpos($identifier, 'learning') !== false) {
            $modules = $this->routeConfig->getModulesByFrontName('tutorial');
            if (empty($modules)) {
                return null;
            }
            // set values only after all the checks are done
            $request->setModuleName('tutorial');
            $request->setControllerName('index');
            $request->setActionName('index');

            $request->setControllerModule($modules[0]);
            $request->setRouteName($this->routeConfig->getRouteByFrontName('tutorial'));

            $actionClassName = $this->actionList->get($modules[0], null, 'index', 'index');
            return $this->actionFactory->create($actionClassName);
        }

        return null;
    }
}
