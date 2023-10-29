<div align="center">

# Magento 2 Product QR Code

</div>

## Overview
Magento 2 Product QR Code is an extension that facilitates the generation of QR codes for product pages and adding products to the cart. Extension was developed using Magento 2.4.6 version.

## Usage

1. Log in to the Magento admin panel.
2. Navigate to the product edit.
3. You will find the "Get Product QR" and "Get Add To Cart QR" buttons.
4. Click on the respective button to download the QR code.


![Magento 2 Product QR Code - Admin Product Edit](https://drive.google.com/uc?export=view&id=1Y913Ti0-OX5bman5yzfC1Z6aBTcLt4tF)

## 🛠️ Installation

### Using Zip File
* Download the [Extension Zip File](https://github.com/HenrijsL/magento2-product-qr-code/archive/master.zip)
* Extract & upload the files to `/path/to/magento2/app/code/Henrijs/ProductQr/`

After installation by either means, activate the extension with following steps

1. Enable the module
```
php bin/magento module:enable Henrijs_ProductQr
php bin/magento setup:upgrade
```
2. Flush the store cache
```
php bin/magento cache:flush
```

## Need Support?
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/HenrijsL/magento2-product-qr-code/issues).

