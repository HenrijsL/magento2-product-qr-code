<?php
namespace Henrijs\ProductQr\Block\Adminhtml\Product\Edit\Button;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ProductQrButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Get Product QR'),
            'class' => 'action-secondary',
            'on_click' => "window.location = '{$this->getProductQrUrl()}'",
            'sort_order' => 100
        ];
    }

    public function getProductQrUrl()
    {
        return $this->getUrl(
            'productqr/index/createQr',
            [
                'product_id' => $this->registry->registry('product')->getEntityId(),
                'type' => 'product'
            ]
        );
    }
}
