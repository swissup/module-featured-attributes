<?php
namespace Swissup\FeaturedAttributes\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to store config: extension enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED = 'featuredattributes/general/enabled';

    /**
     * Path to store config: selected attributes
     *
     * @var string
     */
    const XML_PATH_ATTRIBUTES = 'featuredattributes/general/attributes';

    protected function getConfig($key)
    {
        return $this->scopeConfig->getValue($key, ScopeInterface::SCOPE_STORE);
    }

    public function isEnabled()
    {
        return (bool)$this->getConfig(self::XML_PATH_ENABLED);
    }

    public function getAttributes()
    {
        return $this->getConfig(self::XML_PATH_ATTRIBUTES);
    }
}
