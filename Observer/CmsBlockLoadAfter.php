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
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Cms\Model\Block $block */
        $block = $observer->getDataObject();
        $html = '';
        if ($customCss = trim($block->getCustomCss())) {
            $html = '<style>';
            $html .= $customCss;
            $html .= '</style>';

        }
        if ($js = $block->getCustomJs()) {
            $html .= '<script>' . $js . '</script>';
        }
        if ($html && strpos($block->getContent(), $html) === false) {
            $block->setContent($block->getContent() . $html);

        }

        return $this;
    }

}