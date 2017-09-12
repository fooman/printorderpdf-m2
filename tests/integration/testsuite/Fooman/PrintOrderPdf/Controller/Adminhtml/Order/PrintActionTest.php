<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_PrintOrderPdf
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\PrintOrderPdf\Controller\Adminhtml\Order;

/**
 * @magentoAppArea adminhtml
 * @magentoDataFixture Magento/Sales/_files/order.php
 */
class PrintActionTest extends \Magento\TestFramework\TestCase\AbstractBackendController
{
    public function setUp()
    {
        $order = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Sales\Model\Order'
        )->loadByIncrementId('100000001');

        $this->resource = 'Magento_Sales::sales_order';
        $this->uri = 'backend/fooman_printorderpdf/order/print/order_id/'.$order->getId();
        parent::setUp();
    }
}
