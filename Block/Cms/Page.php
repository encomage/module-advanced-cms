<?php
/**
 * advanced-cms.extension
 *
 * @category advanced-cms.extension-module
 * @package  Encomage_AdvancedCms
 * @author   Encomage <hello@encomage.com>
 * @license  OSL https://opensource.org/licenses/OSL-3.0
 * @link     http://encomage.com
 */

namespace Encomage\AdvancedCms\Block\Cms;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\Page as PageModel;
use Magento\Framework\View\Element\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Page
 *
 * @category Magento2-module
 * @package  Encomage\AdvancedCms\Block\Cms
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Page extends AbstractBlock
{

    /**
     * @var PageModel
     */
    protected $pageModel;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Page constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param PageFactory $pageFactory
     * @param PageModel $pageModel
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        PageFactory $pageFactory,
        PageModel $pageModel,

        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pageFactory = $pageFactory;
        $this->pageModel = $pageModel;
        $this->storeManager = $storeManager;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPage()
    {
        if (!$this->hasData('current_page')) {
            if ($this->getPageId()) {
                /** @var \Magento\Cms\Model\Page $page */
                $page = $this->pageFactory->create();
                $page
                    ->setStoreId([$this->getStore()->getId()])
                    ->load($this->getPageId(), 'page_id');
            } else {
                $page = $this->pageModel;
            }
            $this->setData('current_page', $page);
        }

        return $this->getData('current_page');
    }

    /**
     * @return int
     */
    protected function getPageId()
    {
        return (int)$this->getRequest()->getParam('page_id', 0);
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getStore()
    {
       return $this->storeManager->getStore();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toHtml()
    {
        $html = '';
        if ($css = trim($this->getPage()->getCustomCss())) {
            $html .= '<style>' . $css . '</style>';
        }
        if ($js = $this->getPage()->getCustomJs()) {
            $html .= '<script>' . $js . '</script>';

        }

        return $html;
    }

}