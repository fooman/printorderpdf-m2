<?php

namespace Fooman\PrintOrderPdf\Test\TestCase;

/**
 * Class PrintOrderFromAdmin
 *
 * @group   Fooman
 * @package Fooman\PrintOrderPdf\Test\TestCase
 */
class PrintOrderFromAdminTest extends Common
{

    public function testPrint()
    {
        // Preconditions
        $order = $this->createOrder();

        // Steps
        $this->orderIndex->open();
        $this->orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $order->getId()]);

        return ['url' => $this->salesOrderView->getPrintActions()->printUrl()];
    }


}
