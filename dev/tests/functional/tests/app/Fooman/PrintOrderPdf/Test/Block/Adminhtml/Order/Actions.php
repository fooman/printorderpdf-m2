<?php

namespace Fooman\PrintOrderPdf\Test\Block\Adminhtml\Order;

class Actions extends \Magento\Sales\Test\Block\Adminhtml\Order\Actions
{

    /**
     * 'Print' button
     *
     * @var string
     */
    protected $print = '#fooman_print';

    /**
     * Print order
     *
     * @return void
     */
    public function printAction()
    {
        $this->_rootElement->find($this->print)->click();
    }
}
