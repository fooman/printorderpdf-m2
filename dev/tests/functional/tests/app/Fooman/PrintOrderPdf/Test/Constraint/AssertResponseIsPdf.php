<?php

namespace Fooman\PrintOrderPdf\Test\Constraint;


class AssertResponseIsPdf extends \Magento\Mtf\Constraint\AbstractConstraint
{



    public function processAssert(
        \Magento\Mtf\Client\BrowserInterface $browser
    ) {

        \PHPUnit_Framework_Assert::assertEquals(
            1,
            $browser->getUrl(),
            'Response is not a pdf.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'Response is a pdf';
    }
}
