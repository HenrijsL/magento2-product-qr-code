<?php

namespace Henrijs\ProductQr\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\Product;
use Magento\Framework\Message\ManagerInterface;

class AddToCart extends Action
{
    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;


    /**
     *
     * @param Context $context
     * @param FormKey $formKey
     * @param Cart $cart
     * @param Product $product
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Context $context,
        FormKey $formKey,
        Cart $cart,
        Product $product,
        ManagerInterface $messageManager
    ) {
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $productId = $this->_request->getParam('product_id');
        if ($productId != null) {
            try {
                $params = array(
                    'form_key' => $this->formKey->getFormKey(),
                    'product' => $productId,
                    'qty' => 1
                );
                $product = $this->product->load($productId);
                $this->cart->addProduct($product, $params);
                $this->cart->save();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage('Something went wrong');
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
            }
        } else {
            $this->messageManager->addErrorMessage('Product ID is required');
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('checkout/cart/');
    }
}
