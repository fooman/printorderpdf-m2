<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_PrintOrderPdf
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\PrintOrderPdf\Block\Adminhtml;

/**
 * @magentoAppArea adminhtml
 */
class PrintOrderButtonTest extends \Magento\Backend\Utility\Controller
{
    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testPrintOrderButton()
    {
        $orderId = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Sales\Model\Order'
        )->loadByIncrementId('100000001')->getId();
        $this->assertTrue($orderId>0);
        $this->dispatch('backend/sales/order/view/order_id/'.$orderId);
        $this->assertContains('<button id="fooman_print" title="Print"', $this->getResponse()->getBody());
    }
}
