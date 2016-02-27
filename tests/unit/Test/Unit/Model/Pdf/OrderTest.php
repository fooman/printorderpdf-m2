<?php
namespace Fooman\PrintOrderPdf\Test\Unit\Model\Pdf;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for
 * @see Fooman\PrintOrderPdf\Model\Pdf\Order
 */
class OrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Fooman\PrintOrderPdf\Model\Pdf\Order
     */
    protected $object;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $pdfConfigMock = $this->getPdfConfigMock();
        $directoryMock = $this->getDirectoryMock();
        $filesystemMock = $this->getFileSystemMock($directoryMock);


        $storeMock = $this->getMockBuilder('Magento\Store\Model\Store')
            ->disableOriginalConstructor()
            ->getMock();
        $storeMock->expects($this->any())->method('getBaseUrl')->will($this->returnValue('/'));
        $storeManagerMock = $this->getMockForAbstractClass('Magento\Store\Model\StoreManagerInterface');
        $storeManagerMock->expects($this->any())->method('getStore')->will($this->returnValue($storeMock));

        $scopeConfigMock = $this->getMock('Magento\Framework\App\Config\ScopeConfigInterface');
        $localeDataMock = $this->getMock('Magento\Framework\Stdlib\DateTime\TimezoneInterface');
        $inlineTranslationMock = $this->getMock('Magento\Framework\Translate\Inline\StateInterface');
        $localeResolverMock = $this->getMock('Magento\Framework\Locale\ResolverInterface');

        $paymentDataMock = $this->getPaymentDataMock();

        $pdfTotalFactoryMock = $this->getMock(
            'Magento\Sales\Model\Order\Pdf\Total\Factory',
            ['create'],
            [],
            '',
            false
        );

        $pdfTotalFactoryMock->expects($this->any())->method('create')->will(
            $this->returnValue($objectManager->getObject('Magento\Sales\Model\Order\Pdf\Total\DefaultTotal'))
        );

        $pdfItemsFactoryMock = $this->getMock(
            'Magento\Sales\Model\Order\Pdf\ItemsFactory',
            ['get'],
            [],
            '',
            false
        );
        $pdfItemsFactoryMock->expects($this->any())->method('get')->will(
            $this->returnValue($objectManager->getObject('Magento\Sales\Model\Order\Pdf\Items\Invoice\DefaultInvoice'))
        );


        $orderConstructorArgs = [
            'paymentData'       => $paymentDataMock,
            'string'            => $objectManager->getObject('Magento\Framework\Stdlib\StringUtils'),
            'scopeConfig'       => $scopeConfigMock,
            'filesystem'        => $filesystemMock,
            'pdfConfig'         => $pdfConfigMock,
            'pdfTotalFactory'   => $pdfTotalFactoryMock,
            'pdfItemsFactory'   => $pdfItemsFactoryMock,
            'localeDate'        => $localeDataMock,
            'inlineTranslation' => $inlineTranslationMock,
            'storeManager'      => $storeManagerMock,
            'localeResolver'    => $localeResolverMock,
            []
        ];

        $this->object = $objectManager->getObject('Fooman\PrintOrderPdf\Model\Pdf\Order', $orderConstructorArgs);
    }

    public function testGetPdf()
    {
        $orderMock = $this->getMock(
            'Magento\Sales\Model\Order',
            ['getBillingAddress', 'getShippingAddress', 'getStore', 'getCreatedAtStoreDate', 'getPayment',
             'getOrderCurrency', 'getAllItems', 'getStoreId'],
            [],
            '',
            false
        );

        $orderMock->expects($this->any())->method('getStoreId')->will(
            $this->returnValue(\Magento\Store\Model\Store::DISTRO_STORE_ID)
        );

        $orderItemMock = $this->getMock(
            'Magento\Sales\Model\Order\Item',
            ['getProductType'],
            [],
            '',
            false
        );
        $orderItemMock->expects($this->any())->method('getProductType')->will(
            $this->returnValue(
                'default'
            )
        );

        $orderParentItemMock = $this->getMock(
            'Magento\Sales\Model\Order\Item',
            ['getParentItem'],
            [],
            '',
            false
        );
        $orderParentItemMock->expects($this->any())->method('getParentItem')->will(
            $this->returnValue(
                true
            )
        );

        $orderMock->expects($this->any())->method('getAllItems')->will(
            $this->returnValue([$orderParentItemMock, $orderItemMock])
        );


        $addressMock = $this->getMock(
            'Magento\Sales\Model\Order\Address',
            ['format'],
            [],
            '',
            false
        );
        $addressMock->expects($this->any())->method('format')->will(
            $this->returnValue(
                'Street Line 1 with a very long Street name and number 1234567890|Street Line 2|City|Country'
            )
        );
        $orderMock->expects($this->any())->method('getBillingAddress')->will($this->returnValue($addressMock));
        $orderMock->expects($this->any())->method('getShippingAddress')->will($this->returnValue($addressMock));


        $paymentMock = $this->getMock(
            'Magento\Sales\Model\Order\Payment',
            [],
            [],
            '',
            false
        );
        $orderMock->expects($this->any())->method('getPayment')->will($this->returnValue($paymentMock));


        $dateMock = $this->getMock(
            'Magento\Framework\Stdlib\DateTime\Date',
            [],
            [],
            '',
            false
        );
        $orderMock->expects($this->any())->method('getCreatedAtStoreDate')->will($this->returnValue($dateMock));

        $currencyMock = $this->getMock(
            'Magento\Directory\Model\Currency',
            [],
            [],
            '',
            false
        );

        $orderMock->expects($this->any())->method('getOrderCurrency')->will($this->returnValue($currencyMock));

        $pdf = $this->object->getPdf([$orderMock]);
        $this->assertInstanceOf('Zend_Pdf', $pdf);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getPdfConfigMock()
    {
        $pdfConfigMock = $this->getMock(
            'Magento\Sales\Model\Order\Pdf\Config',
            ['getRenderersPerProduct', 'getTotals'],
            [],
            '',
            false
        );
        $pdfConfigMock->expects($this->any())->method('getRenderersPerProduct')->will(
            $this->returnValue(['default' => '>\Magento\Sales\Model\Order\Pdf\Items\Invoice\DefaultInvoice'])
        );

        $pdfConfigMock->expects($this->any())->method('getTotals')->will(
            $this->returnValue(['grand_total' => ['source_field' => 'grand_total']])
        );
        return $pdfConfigMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getDirectoryMock()
    {
        $directoryMock = $this->getMock(
            'Magento\Framework\Filesystem\Directory\Write',
            [],
            [],
            '',
            false,
            false
        );
        $directoryMock->expects($this->any())->method('getAbsolutePath')->will(
            $this->returnCallback(
                function ($argument) {
                    return __DIR__.'/../../../../../../vendor/magento/magento2ce/' . $argument;
                }
            )
        );
        return $directoryMock;
    }

    /**
     * @param $directoryMock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getFileSystemMock($directoryMock)
    {
        $filesystemMock = $this->getMock('Magento\Framework\Filesystem', [], [], '', false, false);
        $filesystemMock->expects($this->any())->method('getDirectoryRead')->will($this->returnValue($directoryMock));
        $filesystemMock->expects($this->any())->method('getDirectoryWrite')->will($this->returnValue($directoryMock));
        return $filesystemMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getPaymentDataMock()
    {
        $paymentDataMock = $this->getMock(
            'Magento\Payment\Helper\Data',
            ['getInfoBlock'],
            [],
            '',
            false
        );

        $blockMock = $this->getMock(
            'Magento\Framework\View\Element\Template',
            ['toPdf'],
            [],
            '',
            false
        );
        $blockMock->expects($this->any())->method('toPdf')->will($this->returnValue('PAYMENT INFO'));

        $paymentDataMock->expects($this->any())->method('getInfoBlock')->will($this->returnValue($blockMock));
        return $paymentDataMock;
    }
}
