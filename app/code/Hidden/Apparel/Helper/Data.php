<?php

namespace Hidden\Apparel\Helper;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;


class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    protected $_storeManager;
    protected $logoblock;
    protected $productCollectionFactory;


    public function __construct(
        \Magento\Framework\App\Helper\Context $context, 
        \Magento\Theme\Block\Html\Header\Logo $logoblock, 
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CollectionFactory $productCollectionFactory

    ) {
        $this->logoblock = $logoblock;
        $this->_storeManager = $storeManager;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }

    public function getBaseUrl() {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getIsHome() {
        return $this->logoblock->isHomePage();
    }

    public function getMediaUrl() {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    
    public function getConfigValue($value = '') {
        return $this->scopeConfig
                ->getValue($value, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getProductCount()
    {
        $productCollection = $this->productCollectionFactory->create();

        // You can apply additional filters if needed, for example, to get only enabled products
        $productCollection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

        $productCount = $productCollection->getSize();

        return $productCount;
    }
}