<?php

namespace Fooman\PrintOrderPdf\Plugin;

class PaymentInfoBlockPlugin
{

    private $replacedTemplates = [
        'Magento_Payment::info/pdf/default.phtml' => 'Fooman_PrintOrderPdf::info/pdf/default.phtml',
        'Magento_OfflinePayments::pdf/checkmo.phtml' => 'Fooman_PrintOrderPdf::info/pdf/checkmo.phtml',
        'Magento_OfflinePayments::pdf/purchaseorder.phtml' => 'Fooman_PrintOrderPdf::info/pdf/purchaseorder.phtml',
    ];

    /**
     * when creating a pdf from a frontend context, the admin pdf template is not found
     * use the copy provided by this extension in the base folder instead
     *
     * @return mixed
     */
    public function aroundToPdf(
        \Magento\Payment\Block\Info $subject,
        \Closure $proceed
    ) {
        $currentTemplate = $subject->getTemplate();
        if (isset($this->replacedTemplates[$currentTemplate])) {
            $subject->setTemplate($this->replacedTemplates[$currentTemplate]);
        }
        return $subject->toHtml();
    }
}