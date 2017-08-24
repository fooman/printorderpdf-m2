<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_PrintOrderPdf
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fooman\PrintOrderPdf\Block;

class PaymentInfoBlockTest extends \PHPUnit\Framework\TestCase
{

    private $objectManager;

    private $helper;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->pdf = $this->objectManager->create(
            '\Fooman\PrintOrderPdf\Model\Pdf\Order'
        );

        $this->helper = $this->objectManager->get('Magento\Payment\Helper\Data');
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     * @magentoAppArea     adminhtml
     */
    public function testToPdfAdmin()
    {
        $order = $this->prepareOrder();
        $paymentInfo = $this->helper->getInfoBlock($order->getPayment())->setIsSecureMode(true);
        $this->assertContains('Check / Money order', $paymentInfo->toPdf());
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     * @magentoAppArea     frontend
     */
    public function testToPdfFrontend()
    {
        $order = $this->prepareOrder();
        $paymentInfo = $this->helper->getInfoBlock($order->getPayment())->setIsSecureMode(true);
        $this->assertContains('Check / Money order', $paymentInfo->toPdf());
    }

    /**
     * @return mixed
     */
    protected function prepareOrder()
    {
        $order = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Sales\Model\Order'
        )->loadByIncrementId('100000001');

        return $order;
    }

}
