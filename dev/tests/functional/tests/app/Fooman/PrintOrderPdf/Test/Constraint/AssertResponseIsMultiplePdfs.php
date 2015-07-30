<?php

namespace Fooman\PrintOrderPdf\Test\Constraint;

use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Sales\Test\Fixture\OrderInjectable;

class AssertResponseIsMultiplePdfs extends \Magento\Mtf\Constraint\AbstractConstraint
{

    /**
     * @param \Magento\Mtf\Config\DataInterface $config
     * @param CurlTransport                     $transport
     * @param OrderInjectable[]                 $orders
     * @param string                            $pdfMarkerExpected
     *
     * @throws \Exception
     */
    public function processAssert(
        \Magento\Mtf\Config\DataInterface $config,
        \Magento\Mtf\Util\Protocol\CurlTransport $transport,
        array $orders,
        $pdfMarkerExpected = '%PDF-1.4'
    ) {
        $url = $_ENV['app_backend_url'] . 'fooman_printorderpdf/order/pdforders/';

        $curl = new BackendDecorator($transport, $config);
        $curl->addOption(CURLOPT_HEADER, 1);
        $curl->write(CurlInterface::POST, $url, '1.0', [], $this->convertIdsToSelected($orders));
        $response = $curl->read();

        $headerSize = $transport->getInfo(CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $headerSize);
        $pdfMarkerActual = substr($response, $headerSize, strlen($pdfMarkerExpected));

        $contentType = $this->getHeaderValue($header, 'Content-Type');
        $curl->close();

        \PHPUnit_Framework_Assert::assertEquals(
            'application/pdf',
            $contentType,
            'Response is not a pdf.'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $pdfMarkerExpected,
            $pdfMarkerActual,
            'Pdf is not the expected version'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'Response is a pdf';
    }

    protected function getHeaderValue($fullHeader, $key)
    {

        if (function_exists('http_parse_headers')) {
            $headerParsed = http_parse_headers($fullHeader);
            if (isset($headerParsed[$key])) {
                return $headerParsed[$key];
            }
        } else {
            //for our purposes we don't need to deal with multi line headers or status
            foreach (explode("\n", $fullHeader) as $headerLine) {
                if (strpos($headerLine, ":") !== false) {
                    list($header, $value) = explode(':', $headerLine, 2);
                    if (trim($header) == $key) {
                        return trim($value);
                    }
                }
            }
        }
    }

    protected function convertIdsToSelected($orders)
    {
        $data = [];
        foreach ($orders as $order) {
            $data['selected'][] = $order->getId();
        }
        return $data;
    }

}
