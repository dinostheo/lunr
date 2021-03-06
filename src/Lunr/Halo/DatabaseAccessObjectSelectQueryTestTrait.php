<?php

/**
 * This file contains the DatabaseAccessObjectSelectQueryTestTrait.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Halo
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo;

/**
 * This trait contains helper methods to test general success and error cases of SELECT queries.
 *
 * @category   Tests
 * @package    Halo
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
trait DatabaseAccessObjectSelectQueryTestTrait
{

    /**
     * Expect that a query returns successful results.
     *
     * @param mixed  $data   Result data
     * @param String $format Return result as 'array', 'row', 'column' or 'cell'
     *
     * @return void
     */
    public function expextResultOnSuccess($data, $format = 'array')
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(FALSE));

        $this->result->expects($this->once())
                     ->method('number_of_rows')
                     ->will($this->returnValue(count($data)));

        $this->result->expects($this->once())
                     ->method('result_' . $format)
                     ->will($this->returnValue($data));
    }

    /**
     * Expect that a query returns no results.
     *
     * @param String $format Return result as 'array', 'row', 'column' or 'cell'
     *
     * @return void
     */
    public function expectNoResultsFound($format = 'array')
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(FALSE));

        $this->result->expects($this->once())
                     ->method('number_of_rows')
                     ->will($this->returnValue(0));

        $this->result->expects($this->never())
                     ->method('result_' . $format);
    }

    /**
     * Expect that a query returns an error.
     *
     * @return void
     */
    protected function expectQueryError()
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(TRUE));
    }

    /**
     * Expect that a query is successful.
     *
     * @return void
     */
    protected function expectQuerySuccess()
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(FALSE));
    }

}

?>
