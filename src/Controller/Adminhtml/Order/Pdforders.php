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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Pdforders extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;


    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * Pdforders constructor.
     *
     * @param \Magento\Backend\App\Action\Context                        $context
     * @param \Magento\Ui\Component\MassAction\Filter                    $filter
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Response\Http\FileFactory           $fileFactory
     * @param \Fooman\PrintOrderPdf\Model\Pdf\OrderFactory               $orderPdfFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime                $date
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Fooman\PrintOrderPdf\Model\Pdf\OrderFactory $orderPdfFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->fileFactory = $fileFactory;
        $this->orderPdfFactory = $orderPdfFactory;
        $this->date = $date;
        parent::__construct($context, $filter);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Sales::sales_order');
    }

    /**
     * Print selected orders
     *
     * @param AbstractCollection $collection
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $pdf = $this->orderPdfFactory->create()->getPdf($collection);
        $date = $this->date->date('Y-m-d_H-i-s');

        return $this->fileFactory->create(
            __('orders') . '_' . $date . '.pdf',
            $pdf->render(),
            DirectoryList::VAR_DIR,
            'application/pdf'
        );
    }
}
