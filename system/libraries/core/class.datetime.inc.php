<?php

/**
 * This file contains the class DateTime, which is a collection
 * of commonly used Date and Time methods.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 *
 */

namespace Lunr\Libraries\Core;

/**
 * Date/Time related functions
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 *
 */
class DateTime
{

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
     * Return today's date (YYYY-MM-DD).
     *
     * @return String Today's date
     */
    public function today()
    {
        return date('Y-m-d');
    }

    /**
     * Return yesterday's date (YYYY-MM-DD).
     *
     * @return String Tomorrow's date
     */
    public function yesterday()
    {
        return date('Y-m-d', strtotime('-1 day'));
    }

    /**
     * Return tomorrow's date (YYYY-MM-DD).
     *
     * @return String Tomorrow's date
     */
    public function tomorrow()
    {
        return date('Y-m-d', strtotime('+1 day'));
    }

    /**
     * Return a date of a certain timeframe in the past/future.
     *
     * @param String  $delay     Definition for a timeframe
     *                           ("+1 day", "-10 minutes")
     * @param Integer $timestamp Base timestamp, now by default (optional)
     *
     * @return String Delayed date
     */
    public function delayed_date($delay, $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return date('Y-m-d', strtotime($delay, $timestamp));
    }

    /**
     * Return a timestamp of a certain timeframe in the past/future.
     *
     * @param String  $delay     Definition for a timeframe
     *                           ("+1 day", "-10 minutes")
     * @param Integer $timestamp Base timestamp, now by default (optional)
     *
     * @return Integer Delayed timestamp
     */
    public function delayed_timestamp($delay, $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return strtotime($delay, $timestamp);
    }

    /**
     * Return a delayed datetime string.
     *
     * @param String  $delay     Definition for a timeframe
     *                           ("+1 day", "-10 minutes")
     * @param Integer $timestamp Base timestamp, now by default (optional)
     *
     * @return String $return DateTime definition, format YYYY-MM-DD HH:MM:SS
     */
    public function delayed_datetime($delay, $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return date('Y-m-d H:i:s', strtotime($delay, $timestamp));
    }

    /**
    * Return a delayed date string formatted as "DD Month, YYYY" (eg 05 December, 2011).
    *
    * @param String  $delay     Definition for a timeframe ("+1 day", "-10 minutes")
    * @param String  $locale    The locale that should be used for the month
    * @param Integer $timestamp Base timestamp, now by default (optional)
    *
    * @return String $return Delayed date, format "DD Month, YYYY"
    */
    public function delayed_text_date($delay, $locale = 'en_US', $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return M2DateTime::get_text_date(strtotime($delay, $timestamp), $locale);
    }

    /**
     * Return the current time (HH:MM:SS).
     *
     * @return String current time
     */
    public function now()
    {
        return strftime('%H:%M:%S', time());
    }

    /**
     * Return a date formatted as "MMM" (DEC).
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     * @param String  $locale    The locale that should be used for the month
     *                           names (optional, en_US by default)
     *
     * @return String $date Date as a string
     */
    public function get_short_textmonth($timestamp = FALSE, $locale = 'en_US')
    {
        setlocale(LC_ALL, $locale);
        if ($timestamp === FALSE)
        {
            return strtoupper(strftime('%b', time()));
        }
        else
        {
            return strtoupper(strftime('%b', $timestamp));
        }
    }

    /**
     * Returns a MySQL compatible date definition.
     *
     * @param Integer $timestamp PHP-like Unix Timestamp
     *
     * @return String $date Date as a string
     */
    public function get_date($timestamp)
    {
        return date('Y-m-d', $timestamp);
    }

    /**
     * Returns a MySQL compatible time definition.
     *
     * @param Integer $timestamp PHP-like Unix Timestamp
     *
     * @return String $time Time as a string
     */
    public function get_time($timestamp)
    {
        return strftime('%H:%M:%S', $timestamp);
    }

    /**
     * Returns a MySQL compatible Date & Time definition.
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     *
     * @return String $datetime Date & Time as a string
     */
    public function get_datetime($timestamp = FALSE)
    {
        if ($timestamp === FALSE)
        {
            return date('Y-m-d H:i', time());
        }
        else
        {
            return date('Y-m-d H:i', $timestamp);
        }
    }

    /**
     * Return a date formatted as "DD MMM" (eg 05 Dec).
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     * @param String  $locale    The locale that should be used for the month
     *                           names (optional, en_US by default)
     *
     * @return String $date Date as a string
     */
    public function get_short_date($timestamp = FALSE, $locale = 'en_US')
    {
        setlocale(LC_ALL, $locale);
        if ($timestamp === FALSE)
        {
            return strtoupper(strftime('%d %b', time()));
        }
        else
        {
            return strtoupper(strftime('%d %b', $timestamp));
        }
    }

    /**
     * Return a date formatted as "DD Month, YYYY" (eg 04 August, 2011).
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     * @param String  $locale    The locale that should be used for the month
     *                           names (optional, en_US by default)
     *
     * @return String $date Date as a string
     */
    public function get_text_date($timestamp = FALSE, $locale = 'en_US')
    {
        setlocale(LC_ALL, $locale);
        if ($timestamp === FALSE)
        {
            return ucwords(strftime('%d %B, %Y', time()));
        }
        else
        {
            return ucwords(strftime('%d %B, %Y', $timestamp));
        }
    }

    /**
     * Checks whether a given input string is a valid time definition.
     *
     * @param String $string Input String
     *
     * @return Boolean $return True if it is valid, False otherwise
     */
    public function is_time($string)
    {
        // accepts HHH:MM:SS, e.g. 23:59:30 or 12:30 or 120:17
        if (preg_match('/^(\-)?[0-9]{1,3}(:[0-5][0-9]){1,2}$/', $string))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Checks whether a given input string is a valid date definition.
     *
     * @param String $string Input String
     *
     * @return Boolean $return True if it is a proper date String,
     *                         False otherwise
     */
    public function is_date($string)
    {
        $leap_day = '/^(\d{1,4})[\- \/ \.]02[\- \/ \.]29$/';

        if (preg_match($leap_day, $string))
        {
            $year = preg_replace('/[\- \/ \.]02[\- \/ \.]29$/', '', $string);
            return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)));
        }
        else
        {
            $feb     = '02[\- \/ \.](0[1-9]|1[0-9]|2[0-8])';
            $_30days = '(0[469]|11)[\- \/ \.](0[1-9]|[12][0-9]|30)';
            $_31days = '(0[13578]|1[02])[\- \/ \.](0[1-9]|[12][0-9]|3[01])';

            if (preg_match("/^(\d{1,4})[\- \/ \.]($_31days|$_30days|$feb)$/", $string))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
     * Compares two datetime strings and returns smaller or bigger.
     *
     * This function can be used for PHP's sorting functions.
     *
     * @param String $a DateTime String 1
     * @param String $b DateTime String 2
     *
     * @return Integer -1 if $a < $b, 1 otherwise
     */
    public function sort_compare_datetime($a, $b)
    {
        $a = strtotime($a);
        $b = strtotime($b);

        if ($a == $b)
        {
            return 0;
        }
        else
        {
            return ($a < $b) ? -1 : 1;
        }
    }

}

?>
