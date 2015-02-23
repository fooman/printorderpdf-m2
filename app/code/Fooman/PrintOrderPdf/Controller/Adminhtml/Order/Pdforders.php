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

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Pdforders extends \Fooman\PrintOrderPdf\Controller\Adminhtml\Order\AbstractOrder\Pdf
{

    /**
     * @return ResponseInterface|void
     */
    public function execute()
    {
        $orderIds = $this->getRequest()->getPost('order_ids');
        if (!empty($orderIds)) {
            $invoices = $this->_objectManager->create('Magento\Sales\Model\Resource\Order\Collection')
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('entity_id', ['in' => $orderIds])
                ->load();
            if (!isset($pdf)) {
                $pdf = $this->_objectManager->create('Fooman\PrintOrderPdf\Model\Pdf\Order')->getPdf($invoices);
            } else {
                $pages = $this->_objectManager->create('Fooman\PrintOrderPdf\Model\Pdf\Order')->getPdf($invoices);
                $pdf->pages = array_merge($pdf->pages, $pages->pages);
            }
            $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->date('Y-m-d_H-i-s');

            return $this->_fileFactory->create(
                'orders' . $date . '.pdf',
                $pdf->render(),
                DirectoryList::VAR_DIR,
                'application/pdf'
            );
        }
        return $this->_resultRedirectFactory->create()->setPath('sales/*/');
    }
}
