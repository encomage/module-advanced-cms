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

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Request\Http;

/**
 * Class AddFrontendOptionsObserver
 *
 * @category Magento2-module
 * @package  Encomage\AdvancedCms\Observer
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class LayoutLoadBefore implements ObserverInterface
{
    const CMS_ACTION_INDEX   = 'cms_index_index';
    const CMS_ACTION_VIEW    = 'cms_page_view';
    const CMS_ACTION_NO_ROUT = 'cms_noroute_index';

    /**
     * @var Http
     */
    protected $http;

    /**
     * AddFrontendOptionsObserver constructor.
     *
     * @param Http $http
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $layout = $observer->getData('layout');

        $handles = $layout->getUpdate()->getHandles();
        if (!in_array('default', $handles)) {
            return $this;
        }

        if ($this->http->getFullActionName() == self::CMS_ACTION_INDEX
            || $this->http->getFullActionName() == self::CMS_ACTION_VIEW
            || $this->http->getFullActionName() == self::CMS_ACTION_NO_ROUT) {
            $layout->getUpdate()->addHandle('encomage_advanced_cms_page');
        }

        return $this;
    }
}