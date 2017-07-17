<?php
namespace Norair\Redproducts\Block;

class Redproducts extends \Magento\Framework\View\Element\Template {
    protected $_productRepository;

    public function __construct(\Magento\Backend\Block\Template\Context $context,
            \Magento\Catalog\Model\ProductRepository $productRepository, array $data = [],
            \Magento\Framework\Api\SearchCriteriaInterface $criteria,
            \Magento\Framework\Api\Search\FilterGroup $filterGroup,
            \Magento\Framework\Api\FilterBuilder $filterBuilder,
            \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
            \Magento\Catalog\Model\Product\Visibility $productVisibility) {
        $this->productRepository = $productRepository;
        $this->searchCriteria = $criteria;
        $this->filterGroup = $filterGroup;
        $this->filterBuilder = $filterBuilder;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        parent::__construct($context, $data);
    }

    public function getHelloWorldTxt() {
        return 'Rote Produkte';
    }

    public function getProductsData() {

        $this->filterGroup->setFilters([
            $this->filterBuilder
                ->setField('status')
                ->setConditionType('in')
                ->setValue($this->productStatus->getVisibleStatusIds())
                ->create(),
            $this->filterBuilder
                ->setField('visibility')
                ->setConditionType('in')
                ->setValue($this->productVisibility->getVisibleInSiteIds())
                ->create(),
        ]);

        $this->searchCriteria->setFilterGroups([$this->filterGroup]);
        $products = $this->productRepository->getList($this->searchCriteria);
        $productItems = $products->getItems();

        return $productItems;
    }
}