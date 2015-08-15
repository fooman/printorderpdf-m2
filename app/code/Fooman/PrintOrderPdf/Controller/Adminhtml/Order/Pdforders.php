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
use Magento\Framework\Model\Resource\Db\Collection\AbstractCollection;

class Pdforders extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{

    protected $collection = 'Magento\Sales\Model\Resource\Order\Collection';

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $_resultRedirectFactory;

    /**
     * @param \Magento\Backend\App\Action\Context                $context
     * @param \Magento\Ui\Component\MassAction\Filter            $filter
     * @param \Magento\Framework\App\Response\Http\FileFactory   $fileFactory
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
    ) {
        $this->_fileFactory = $fileFactory;
        $this->_resultRedirectFactory = $resultRedirectFactory;
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

        if (!isset($pdf)) {
            $pdf = $this->_objectManager->create('Fooman\PrintOrderPdf\Model\Pdf\Order')->getPdf($collection);
        } else {
            $pages = $this->_objectManager->create('Fooman\PrintOrderPdf\Model\Pdf\Order')->getPdf($collection);
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
}
