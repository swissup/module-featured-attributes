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
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Swissup\FeaturedAttributes\Helper\Data          $helper
     * @param array                                            $data
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
     * Get list of featured attributes for product
     *
     * @return array|boolean
     */
    public function getFeaturedAttributes()
    {
        if (!$this->helper->isEnabled() || !$this->product) {
            return false;
        }

        $attributes = [];
        foreach ($this->helper->getAttributes() as $attributeCode => $attribute) {
            if (!is_null($this->product->getData($attributeCode))) {
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
