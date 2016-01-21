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

    /**
     * extract print url from onclick param
     *
     * @return string
     */
    public function printUrl()
    {
        $onclick = $this->_rootElement->find($this->print)->getAttribute('onclick');

        //remove the JS setLocation part
        return substr($onclick, strlen("setLocation('"), -strlen("')"));
    }
}
