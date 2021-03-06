<?php

/**
 * This file contains the PAPDispatcherSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

/**
 * This class contains tests for the setters of the PAPDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\PAP\PAPDispatcher
 */
class PAPDispatcherSetTest extends PAPDispatcherTest
{

    /**
     * Test that set_endpoint() sets the endpoint.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_endpoint
     */
    public function testSetEndpointSetsEndpoint()
    {
        $this->class->set_endpoint('endpoint');

        $this->assertPropertyEquals('endpoint', 'endpoint');
    }

    /**
     * Test the fluid interface of set_endpoint().
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_endpoint
     */
    public function testSetEndpointReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_endpoint('endpoint'));
    }

    /**
     * Test that set_payload() sets the payload.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_payload
     */
    public function testSetPayloadSetsPayload()
    {
        $payload = 'payload';
        $this->class->set_payload($payload);

        $this->assertPropertyEquals('payload', 'payload');
    }

    /**
     * Test the fluid interface of set_payload().
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_payload
     */
    public function testSetPayloadReturnsSelfReference()
    {
        $payload = 'payload';
        $this->assertEquals($this->class, $this->class->set_payload($payload));
    }

    /**
     * Test that set_auth_token() sets the auth_token.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_auth_token
     */
    public function testSetAuthTokenSetsAuthToken()
    {
        $auth_token = 'auth_token';
        $this->class->set_auth_token($auth_token);

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference()
    {
        $auth_token = 'auth_token';
        $this->assertEquals($this->class, $this->class->set_auth_token($auth_token));
    }

    /**
     * Test that set_password() sets the password.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_password
     */
    public function testSetPasswordSetsPassword()
    {
        $password = 'password';
        $this->class->set_password($password);

        $this->assertPropertyEquals('password', 'password');
    }

    /**
     * Test the fluid interface of set_password().
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_password
     */
    public function testSetPasswordReturnsSelfReference()
    {
        $password = 'password';
        $this->assertEquals($this->class, $this->class->set_password($password));
    }

    /**
     * Test that set_content_provider_id() sets the cid.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_content_provider_id
     */
    public function testSetContentProviderIdSetsCid()
    {
        $cid = 'cid';
        $this->class->set_content_provider_id($cid);

        $this->assertPropertyEquals('cid', 'cid');
    }

    /**
     * Test the fluid interface of set_content_provider_id().
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_content_provider_id
     */
    public function testSetContentProviderIdReturnsSelfReference()
    {
        $cid = 'cid';
        $this->assertEquals($this->class, $this->class->set_content_provider_id($cid));
    }

    /**
     * Test that set_deliver_before_timestamp() sets the deliverbefore.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_deliver_before_timestamp
     */
    public function testSetDeliverBeforeTimestampSetsDeliverBefore()
    {
        $deliverbefore = 'deliverbefore';
        $this->class->set_deliver_before_timestamp($deliverbefore);

        $this->assertPropertyEquals('deliverbefore', 'deliverbefore');
    }

    /**
     * Test the fluid interface of set_deliver_before_timestamp().
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::set_deliver_before_timestamp
     */
    public function testSetDeliverBeforeTimestampReturnsSelfReference()
    {
        $cid = 'cid';
        $this->assertEquals($this->class, $this->class->set_deliver_before_timestamp($cid));
    }

}

?>