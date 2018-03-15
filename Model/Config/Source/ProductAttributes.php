<?php
namespace Swissup\FeaturedAttributes\Model\Config\Source;

class ProductAttributes implements \Magento\Framework\Option\ArrayInterface
{
    const ALLOWED_TYPES = ['text', 'boolean', 'date', 'select', 'multiselect'];

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory
     */
    private $attrCollection;

    /**
     * Constructor
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attrCollection
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attrCollection
    ) {
        $this->attrCollection = $attrCollection;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $attributes = $this->attrCollection->create()
            ->addVisibleFilter()
            ->addFieldToFilter('used_in_product_listing', 1)
            ->addFieldToFilter('frontend_input', ['in' => self::ALLOWED_TYPES])
            ->setOrder('frontend_label', 'asc')
            ->load();

        $optionArray = [];
        foreach ($attributes as $attribute) {
            $optionArray[] = [
                'label' => $attribute->getFrontendLabel(),
                'value' => $attribute->getAttributeCode()
            ];
        }

        return $optionArray;
    }
}
