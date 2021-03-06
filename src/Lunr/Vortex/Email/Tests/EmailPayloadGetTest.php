<?php

/**
 * This file contains the EmailPayloadGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains tests for the getters of the EmailPayload class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\Email\EmailPayload
 */
class EmailPayloadGetTest extends EmailPayloadTest
{

    /**
     * Test get_payload() with the message being present.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::get_payload
     */
    public function testGetPayload()
    {
        $file     = TEST_STATICS . '/Vortex/email_payload.json';
        $elements = [
                'subject' => 'value1',
                'body'    => 'value2'
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

}

?>
