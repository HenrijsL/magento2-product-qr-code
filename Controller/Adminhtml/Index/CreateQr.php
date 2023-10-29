<?php

namespace Henrijs\ProductQr\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;

class CreateQr extends Action
{
    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     *
     * @param FileFactory $fileFactory
     * @param Context $context
     * @param ProductRepository $productRepository
     * @param JsonFactory $resultJsonFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        FileFactory $fileFactory,
        Context $context,
        ProductRepository $productRepository,
        JsonFactory $resultJsonFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->fileFactory = $fileFactory;
        $this->_productRepository = $productRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $productId = $this->getRequest()->getParam('product_id');
        $type = $this->getRequest()->getParam('type');

        if ($productId != null && $type != null) {
            try {
                $product = $this->_productRepository->getById($productId);

                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($type == "add_to_cart" ? $this->getAddToCartUrl($productId) : $product->getProductUrl())
                    ->encoding(new Encoding('UTF-8'))
                    ->size(300)
                    ->margin(10)
                    ->validateResult(false)
                    ->build();

                return $this->fileFactory->create(
                    $product->getSku() . '-' . $type . '-qr.png',
                    @file_get_contents($result->getDataUri())
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage('Something went wrong');
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);

                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('catalog/product/edit', ['id' => $productId]);
            }
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['json_data' => "Parameters 'product_id' and 'type' is required"]);
    }

    public function getAddToCartUrl($productId)
    {
        return $this->storeManager->getStore()->getBaseUrl() . 'productqr/index/addToCart/product_id/' . $productId;
    }
}
