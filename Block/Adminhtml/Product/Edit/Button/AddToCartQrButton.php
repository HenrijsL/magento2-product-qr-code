<?php
namespace Henrijs\ProductQr\Block\Adminhtml\Product\Edit\Button;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AddToCartQrButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Get Add To Cart QR'),
            'class' => 'action-secondary',
            'on_click' => "window.location = '{$this->getAddToCartQrUrl()}'",
            'sort_order' => 100
        ];
    }

    public function getAddToCartQrUrl()
    {
        return $this->getUrl(
            'productqr/index/createQr',
            [
                'product_id' => $this->registry->registry('product')->getEntityId(),
                'type' => 'add_to_cart'
            ]
        );
    }
}
