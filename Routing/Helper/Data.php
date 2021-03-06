<?php
/**
 * Scommerce routing helper class for common functions and retrieving configuration values
 *
 * @category   Scommerce
 * @package    Scommerce_Routing
 * @author     Scommerce Mage <core@scommerce-mage.com>
 */

namespace Scommerce\Routing\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Model\Exception;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * variable to check if extension is enable or not
     *
     * @var bool
     */
    const ENABLED = 'routing/general/enabled';

    /**
     * variable to get licence key
     *
     * @var string
     */
    const LICENSE_KEY = 'routing/general/license_key';

    /**
     * returns whether module is enabled or not
     * @param int $storeId
     * @return boolean
     */
    public function isEnabled($storeId = null)
    {
        $enabled = $this->isSetFlag(self::ENABLED,ScopeInterface::SCOPE_STORE, $storeId);
        return $this->isCliMode() ? $enabled : $enabled;
    }

    /**
     * Returns license key administration configuration option
     * @param int $storeId
     * @return string
     */
    public function getLicenseKey($storeId = null)
    {
        return $this->getValue(self::LICENSE_KEY,ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Check if running in cli mode
     *
     * @return bool
     */
    protected function isCliMode()
    {
        return php_sapi_name() === 'cli';
    }

    /**
     * Helper method for retrieve config value by path and scope
     *
     * @param string $path The path through the tree of configuration values, e.g., 'general/store_information/name'
     * @param string $scopeType The scope to use to determine config value, e.g., 'store' or 'default'
     * @param null|string $scopeCode
     * @return mixed
     */
    protected function getValue($path, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue($path, $scopeType, $scopeCode);
    }

    /**
     * Helper method for retrieve config flag by path and scope
     *
     * @param string $path The path through the tree of configuration values, e.g., 'general/store_information/name'
     * @param string $scopeType The scope to use to determine config value, e.g., 'store' or 'default'
     * @param null|string $scopeCode
     * @return bool
     */
    protected function isSetFlag($path, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->isSetFlag($path, $scopeType, $scopeCode);
    }
}
