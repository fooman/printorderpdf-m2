<?php

namespace Fooman\PrintOrderPdf\Test\Constraint;


class AbstractAssertPdf extends \Magento\Mtf\Constraint\AbstractConstraint
{
    /**
     * @return string
     */
    public function toString()
    {
        return 'Response is a pdf';
    }

    /**
     * @param $fullHeader
     * @param $key
     *
     * @return string
     */
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
        return '';
    }
}
