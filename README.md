# Featured Attributes

## Extension Manual

http://docs.swissuplabs.com/m2/extensions/featured-attributes/

## Installation

### For clients

There are several ways to install extension for clients:

 1. If you've bought the product at Magento's Marketplace - use
    [Marketplace installation instructions](https://docs.magento.com/marketplace/user_guide/buyers/install-extension.html)
 2. Otherwise, you have two options:
    - Install the sources directly from [our repository](https://docs.swissuplabs.com/m2/extensions/featured-attributes/installation/composer/) - **recommended**
    - Download archive and use [manual installation](https://docs.swissuplabs.com/m2/extensions/featured-attributes/installation/manual/)

### For developers

Use this approach if you have access to our private repositories!

```bash
cd <magento_root>
composer config repositories.swissup composer https://docs.swissuplabs.com/packages/
composer require swissup/module-featured-attributes --prefer-source
bin/magento module:enable Swissup_Core Swissup_FeaturedAttributes
bin/magento setup:upgrade
```

## Usage

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

Enable extension and select attributes to display in
`Stores > Configuration > Swissup > Featured Attributes`.
