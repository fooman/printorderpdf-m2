<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_PrintOrderPdf
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\PrintOrderPdf\Model\Pdf;

class BundleItems extends Magento\Bundle\Model\Sales\Order\Pdf\Items\Invoice
{
    public function getChildren($orderItem)
    {

        $itemsArray = array();
        $items = $orderItem->getOrder()->getAllItems();

        if ($items) {
            foreach ($items as $item) {
                $parentItem = $item->getParentItem();
                $item->setQty($item->getQtyOrdered());
                $item->setOrderItem($item);
                if ($parentItem) {
                    $itemsArray[$parentItem->getId()][$item->getId()] = $item;
                } else {
                    $itemsArray[$item->getId()][$item->getId()] = $item;
                }
            }
        }

        if (isset($itemsArray[$orderItem->getId()])) {
            return $itemsArray[$orderItem->getId()];
        } else {
            return null;
        }
    }
}

