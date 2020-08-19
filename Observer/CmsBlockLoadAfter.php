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

namespace Encomage\AdvancedCms\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Layout;
use Magento\Framework\View\Element\Template;

/**
 * Class CmsBlockLoadAfter
 *
 * @category Magento2-module
 * @package  Encomage\AdvancedCms\Observer
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class CmsBlockLoadAfter implements ObserverInterface
{
    /**
     * @var Layout
     */
    private $layout;


    /**
     * CmsBlockLoadAfter constructor.
     * @param Layout $layout
     */
    public function __construct(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Cms\Model\Block $block */
        $block = $observer->getDataObject();
        $advancedSettings = '';
        if ($customCss = trim($block->getCustomCss())) {
            $advancedSettings .= '<style>' . $customCss . '</style>';
        }
        if ($js = $block->getCustomJs()) {
            $advancedSettings .= '<script>' . $js . '</script>';
        }
        if ($block->getUseAsPopUp()) {
            $block->setContent(
                $this->layout
                    ->createBlock(Template::class)
                    ->setTemplate('Encomage_AdvancedCms::cms/block/pop-up.phtml')
                    ->setCmsBlock($block)
                    ->toHtml()
            );
        }
        if ($advancedSettings && strpos($block->getContent(), $advancedSettings) === false) {
            $block->setContent($block->getContent() . $advancedSettings);
        }

        return $this;
    }
}
