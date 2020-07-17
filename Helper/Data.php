<?php
namespace Swissup\FeaturedAttributes\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Data extends Helper\AbstractHelper
{
    /**
     * @var array
     */
    private $attributes;

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

    /**
     * @param ProductAttributeRepositoryInterface $attributeRepository
     * @param SearchCriteriaBuilder               $searchCriteriaBuilder
     * @param Helper\Context                      $context
     */
    public function __construct(
        ProductAttributeRepositoryInterface $attributeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Helper\Context $context
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    /**
     * @param  string $key
     * @return mixed
     */
    protected function getConfig($key)
    {
        return $this->scopeConfig->getValue($key, ScopeInterface::SCOPE_STORE);
    }

    /**
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return (bool) $this->getConfig(self::XML_PATH_ENABLED);
    }

    /**
     *
     * @return array
     */
    public function getAttributes()
    {
        if (!isset($this->attributes)) {
            $this->attributes = [];
            $attributeCodes = array_filter(
                explode(
                    ',',
                    $this->getConfig(self::XML_PATH_ATTRIBUTES)
                )
            );
            if ($attributeCodes) {
                $criteria = $this->searchCriteriaBuilder
                    ->addFilter('attribute_code', $attributeCodes, 'in')
                    ->create();
                $list = $this->attributeRepository->getList($criteria);
                foreach ($list->getItems() as $attribute) {
                    $this->attributes[$attribute->getAttributeCode()] = $attribute;
                }
            }
        }

        return $this->attributes;
    }
}
