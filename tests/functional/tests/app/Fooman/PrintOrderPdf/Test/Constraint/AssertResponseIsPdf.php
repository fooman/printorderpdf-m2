<?php

namespace Fooman\PrintOrderPdf\Test\Constraint;

use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class AssertResponseIsPdf extends AbstractAssertPdf
{

    /**
     * @param \Magento\Mtf\Config\DataInterface $config
     * @param CurlTransport                     $transport
     * @param string                            $url
     * @param string                            $pdfMarkerExpected
     *
     * @throws \Exception
     */
    public function processAssert(
        \Magento\Mtf\Config\DataInterface $config,
        \Magento\Mtf\Util\Protocol\CurlTransport $transport,
        $url = '',
        $pdfMarkerExpected = '%PDF-1.4'
    ) {
        $curl = new BackendDecorator($transport, $config);
        $curl->addOption(CURLOPT_HEADER, 1);
        $curl->write($url, [], CurlInterface::GET);
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

}
