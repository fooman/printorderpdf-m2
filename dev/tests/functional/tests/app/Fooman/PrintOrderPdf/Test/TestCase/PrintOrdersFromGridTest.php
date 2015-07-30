<?php

namespace Fooman\PrintOrderPdf\Test\TestCase;

/**
 * Class PrintOrderFromAdmin
 *
 * @group   Fooman
 * @package Fooman\PrintOrderPdf\Test\TestCase
 */
class PrintOrdersFromGridTest extends Common
{

    /**
     * @param int $nrOrders
     *
     * @return array
     */
    public function test($nrOrders)
    {
        // Preconditions
        $orders = $this->createOrders($nrOrders);

        // Steps
        $this->orderIndex->open();

        return ['orders' => $orders];
    }


}
