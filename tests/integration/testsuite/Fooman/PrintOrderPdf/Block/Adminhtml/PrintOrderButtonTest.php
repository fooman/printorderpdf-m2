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
class PrintOrderButtonTest extends \Magento\TestFramework\TestCase\AbstractBackendController
{
    public function setUp()
    {
        $this->resource = 'Magento_Sales::sales_order';
        $this->uri = 'backend/sales/order';
        parent::setUp();
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testPrintOrderButton()
    {
        $orderId = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Sales\Model\Order'
        )->loadByIncrementId('100000001')->getId();
        $this->dispatch('backend/sales/order/view/order_id/' . $orderId);
        $this->assertContains('<button id="fooman_print" title="Print"', $this->getResponse()->getBody());
    }

    public function testPrintOrdersMassaction()
    {
        $this->dispatch('backend/sales/order');
        $this->assertContains('"type":"fooman_pdforders","label":"Print Orders"', $this->getResponse()->getBody());
    }

    public function testStandardMassactionsShow()
    {
        $this->dispatch('backend/sales/order');
        $this->assertContains('"type":"cancel","label":"Cancel"', $this->getResponse()->getBody());
        $this->assertContains(
            '"type":"print_shipping_label","label":"Print Shipping Labels"',
            $this->getResponse()->getBody()
        );
    }
}
