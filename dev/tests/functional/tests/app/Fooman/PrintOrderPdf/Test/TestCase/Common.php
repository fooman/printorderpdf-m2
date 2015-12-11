<?php

namespace Fooman\PrintOrderPdf\Test\TestCase;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class Common extends Injectable
{
    /**
     * Order index page.
     *
     * @var OrderIndex
     */
    protected $orderIndex;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var \Magento\Sales\Test\Page\Adminhtml\SalesOrderView
     */
    protected $salesOrderView;

    /**
     * Injection data.
     *
     * @param OrderIndex                                        $orderIndex
     * @param FixtureFactory                                    $fixtureFactory
     * @param \Magento\Sales\Test\Page\Adminhtml\SalesOrderView $salesOrderView
     *
     * @return void
     */
    public function __inject(
        OrderIndex $orderIndex,
        FixtureFactory $fixtureFactory,
        \Magento\Sales\Test\Page\Adminhtml\SalesOrderView $salesOrderView
    ) {
        $this->orderIndex = $orderIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->salesOrderView = $salesOrderView;
    }

    /**
     * Create single test order.
     *
     * @return array
     */
    protected function createOrder()
    {

        /** @var OrderInjectable $order */
        $order = $this->fixtureFactory->createByCode('orderInjectable', ['dataset' => 'with_coupon']);
        $order->persist();
        return $order;
    }

    /**
     * create specified number of test orders
     *
     * @param $nrOrders
     *
     * @return array
     */
    protected function createOrders($nrOrders)
    {
        $orders = [];
        for ($i = 0; $i < $nrOrders; $i++) {
            $orders[] = $this->createOrder();
        }
        return $orders;
    }
}
