<?php

/**
 * This file contains an abstraction for the response from the Email service.
 *
 * PHP Version 5.4
 *
 * @category   Response
 * @package    Vortex
 * @subpackage Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

use Lunr\Vortex\PushNotificationStatus;

/**
 * Email notification response wrapper.
 *
 * @category   Response
 * @package    Vortex
 * @subpackage Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 */
class EmailResponse
{

    /**
     * Delivery status.
     * @var Integer
     */
    private $status;

    /**
     * Constructor.
     *
     * @param Boolean         $response Response of the Mail Class.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     * @param String          $email    The email address that the message was sent to.
     */
    public function __construct($response, $logger, $email)
    {
        if ($response === TRUE)
        {
            $this->status = PushNotificationStatus::SUCCESS;
        }
        else
        {
            $this->status = PushNotificationStatus::ERROR;

            $context = [ 'endpoint' => $email ];
            $logger->warning('Sending email notification to {endpoint} failed.', $context);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->status);
    }

    /**
     * Get notification delivery status.
     *
     * @return PushNotificationStatus $status Delivery status
     */
    public function get_status()
    {
        return $this->status;
    }

}

?>
