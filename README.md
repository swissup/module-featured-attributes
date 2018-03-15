# Featured Attributes

### Installation

```bash
cd <magento_root>
composer config repositories.swissup composer https://docs.swissuplabs.com/packages/
composer require swissup/featured-attributes:dev-master --prefer-source
bin/magento module:enable\
    Swissup_Core\
    Swissup_FeaturedAttributes

bin/magento setup:upgrade
```

Insert code in template `/Magento_Catalog/templates/product/list.phtml`

```php
<?php
    if ($this->helper('Magento\Catalog\Helper\Data')->isModuleOutputEnabled('Swissup_FeaturedAttributes')) {
        echo $block->getLayout()
            ->createBlock('Swissup\FeaturedAttributes\Block\Attributes')
            ->setProduct($_product)
            ->toHtml();
    }
?>
```

Enable extension and select attributes to display in `Stores > Configuration > Swissup > Featured Attributes`.
