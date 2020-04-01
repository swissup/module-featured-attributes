<?php
namespace Swissup\FeaturedAttributes\Block;

class Attributes extends \Magento\Framework\View\Element\Template
{
    /**
     * Default template to use
     */
    const DEFAULT_TEMPLATE = 'attributes.phtml';

    /**
     * @var \Swissup\FeaturedAttributes\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    private $product = null;

    /**
     *
     * @var array|null
     */
    private $attributeCodes = null;

    /**
     *
     * @var array
     */
    private $loadedAttributes = [];

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Swissup\FeaturedAttributes\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Swissup\FeaturedAttributes\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    public function _construct()
    {
        if (!$this->hasData('template')) {
            $this->setData('template', self::DEFAULT_TEMPLATE);
        }

        return parent::_construct();
    }

    /**
     * @param  \Magento\Catalog\Model\Product $product
     * @return \Swissup\FeaturedAttributes\Block\Attributes
     */
    public function setProduct(\Magento\Catalog\Model\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     *
     * @return array
     */
    private function getAttributeCodes()
    {
        if ($this->attributeCodes === null) {
            $this->attributeCodes = $this->helper->getAttributes();
        }
        return $this->attributeCodes;
    }

    /**
     *
     * @return array
     */
    private function getProductAttributes()
    {
        $attributeCodes = $this->getAttributeCodes();
        $productId = $this->product->getId();
        $key = $productId . '-' . implode('-', $attributeCodes);

        if (!isset($this->loadedAttributes[$key])) {
            $this->loadedAttributes[$key] = $this->product->getResource()
                ->load($this->product, $productId, $attributeCodes)
                ->getSortedAttributes();
        }

        return $this->loadedAttributes[$key];
    }

    /**
     * Get list of featured attributes for product
     * @return array|boolean
     */
    public function getFeaturedAttributes()
    {
        if (!$this->helper->isEnabled() || !$this->product) {
            return false;
        }

        $attributes = [];
        $attributeCodes = $this->getAttributeCodes();

        // $productAttributes = $this->product->getAttributes();
        $productAttributes = $this->getProductAttributes();

        foreach ($attributeCodes as $attributeCode) {
            if (isset($productAttributes[$attributeCode])
                && !is_null($this->product->getData($attributeCode))
            ) {
                $attribute = $productAttributes[$attributeCode];
                $label = $attribute->getStoreLabel();
                $value = $attribute->getFrontend()->getValue($this->product);
                if ($label && $value) {
                    $attributes[$attributeCode] = [
                        'label' => $label,
                        'value' => $value
                    ];
                }
            }
        }

        return $attributes;
    }
}
