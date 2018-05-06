<?php

namespace Fooman\PrintOrderPdf\Plugin;

class PaymentInfoBlockPlugin
{

    private $appState;

    public function __construct(
        \Magento\Framework\App\State $appState
    ) {
        $this->appState = $appState;
    }

    /**
     * when creating a pdf from a non-admin context the admin pdf template is not found
     * emulate the backend to retrieve it
     *
     * @param \Magento\Payment\Block\Info $subject
     * @param \Closure                    $proceed
     *
     * @return mixed
     * @throws \Exception
     */
    public function aroundToPdf(
        \Magento\Payment\Block\Info $subject,
        \Closure $proceed
    ) {
        return $this->appState->emulateAreaCode(
            'adminhtml',
            $proceed
        );
    }
}
