<?php

namespace Fooman\PrintOrderPdf\Plugin;

class PaymentInfoBlockPlugin
{
    private $replacedTemplates = [
        'Magento_Payment::info/pdf/default.phtml' => 'Fooman_PrintOrderPdf::info/pdf/default.phtml',
        'Magento_OfflinePayments::pdf/checkmo.phtml' => 'Fooman_PrintOrderPdf::info/pdf/checkmo.phtml',
        'Magento_OfflinePayments::pdf/purchaseorder.phtml' => 'Fooman_PrintOrderPdf::info/pdf/purchaseorder.phtml',
        'Magento_OfflinePayments::info/pdf/checkmo.phtml' => 'Fooman_PrintOrderPdf::info/pdf/checkmo.phtml',
        'Magento_OfflinePayments::info/pdf/purchaseorder.phtml' => 'Fooman_PrintOrderPdf::info/pdf/purchaseorder.phtml',
    ];

    /**
     * Correctly change template file based on the current template file
     *
     * @param \Magento\Payment\Block\Info $subject
     * @return null
     */
    public function beforeToHtml(\Magento\Payment\Block\Info $subject) {
        $currentTemplate = $subject->getTemplate();

        if (isset($this->replacedTemplates[$currentTemplate])) {
            $subject->setTemplate($this->replacedTemplates[$currentTemplate]);
        }

        return null;
    }
}
