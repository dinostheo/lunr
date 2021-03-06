<?php

/**
 * This file contains the APNSDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;


/**
 * This class contains test for the push() method of the APNSDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\APNS\APNSDispatcher
 */
class APNSDispatcherPushTest extends APNSDispatcherTest
{

    /**
     * Test that push() returns APNSResponseObject.
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::push
     */
    public function testPushReturnsAPNSResponseObject()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', '{"alert":"apnsmessage","badge":10,"sound":"bingbong.wav","custom_data":{"key1":"value1","key2":"value2"}}');
        $this->set_reflection_property_value('certificate', 'certificate');
        $this->set_reflection_property_value('passphrase', 'passphrase');
        $this->set_reflection_property_value('setup', FALSE);

        foreach ($this->apn_functions as $function)
        {
            $this->mock_function($function, self::APN_RETURN_TRUE);
        }

        $this->assertInstanceOf('Lunr\Vortex\APNS\APNSResponse', $this->class->push());
        $this->assertTrue($this->get_reflection_property_value('setup'));

        foreach ($this->apn_functions as $function)
        {
            $this->unmock_function($function);
        }
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', '{"alert":"apnsmessage","badge":10,"sound":"bingbong.wav","custom_data":{"key1":"value1","key2":"value2"}}');
        $this->set_reflection_property_value('certificate', 'certificate');
        $this->set_reflection_property_value('passphrase', 'passphrase');
        $this->set_reflection_property_value('setup', FALSE);

        foreach ($this->apn_functions as $function)
        {
            $this->mock_function($function, self::APN_RETURN_TRUE);
        }

        $this->class->push();

        foreach ($this->apn_functions as $function)
        {
            $this->unmock_function($function);
        }

        $this->assertTrue($this->get_reflection_property_value('setup'));
        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
    }

}

?>