<?php

/**
 * This file contains the DatabaseAccessObjectResultsTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Tests for returning result information.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseAccessObject
 */
class DatabaseAccessObjectResultsTest extends DatabaseAccessObjectTest
{

    /**
     * Testcase constructor.
     */
    public function setUp()
    {
        $this->setUpNoPool();
    }

    /**
     * Test that result_array() returns FALSE if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_array
     */
    public function testResultArrayReturnsFalseIfQueryFailed()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->once())
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->once())
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', array('query' => 'query', 'error' => 'message'));

        $method = $this->reflection_dao->getMethod('result_array');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invokeArgs($this->dao, array(&$query)));
    }

    /**
     * Test that result_array() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_array
     */
    public function testResultArrayReturnsEmptyArrayIfQueryHasNoResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->reflection_dao->getMethod('result_array');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query));

        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
    }

    /**
     * Test that result_array() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_array
     */
    public function testResultArrayReturnsArrayIfQueryHasResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = array(0 => array('key' => 'value'));

        $query->expects($this->once())
              ->method('result_array')
              ->will($this->returnValue($query_result));

        $method = $this->reflection_dao->getMethod('result_array');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query));

        $this->assertInternalType('array', $result);
        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_row() returns FALSE if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_row
     */
    public function testResultRowReturnsFalseIfQueryFailed()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->once())
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->once())
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', array('query' => 'query', 'error' => 'message'));

        $method = $this->reflection_dao->getMethod('result_row');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invokeArgs($this->dao, array(&$query)));
    }

    /**
     * Test that result_row() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_row
     */
    public function testResultRowReturnsEmptyArrayIfQueryHasNoResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->reflection_dao->getMethod('result_row');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query));

        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
    }

    /**
     * Test that result_row() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_row
     */
    public function testResultRowReturnsArrayIfQueryHasResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = array('key' => 'value');

        $query->expects($this->once())
              ->method('result_row')
              ->will($this->returnValue($query_result));

        $method = $this->reflection_dao->getMethod('result_row');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query));

        $this->assertInternalType('array', $result);
        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_column() returns FALSE if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_column
     */
    public function testResultColumnReturnsFalseIfQueryFailed()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->once())
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->once())
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', array('query' => 'query', 'error' => 'message'));

        $method = $this->reflection_dao->getMethod('result_column');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invokeArgs($this->dao, array(&$query, 'col')));
    }

    /**
     * Test that result_column() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_column
     */
    public function testResultColumnReturnsEmptyArrayIfQueryHasNoResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->reflection_dao->getMethod('result_column');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query, 'col'));

        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
    }

    /**
     * Test that result_column() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_column
     */
    public function testResultColumnReturnsArrayIfQueryHasResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = array(0 => 'value');

        $query->expects($this->once())
              ->method('result_column')
              ->will($this->returnValue($query_result));

        $method = $this->reflection_dao->getMethod('result_column');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query, 'col'));

        $this->assertInternalType('array', $result);
        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_cell() returns FALSE if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_cell
     */
    public function testResultCellReturnsFalseIfQueryFailed()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->once())
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->once())
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', array('query' => 'query', 'error' => 'message'));

        $method = $this->reflection_dao->getMethod('result_cell');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invokeArgs($this->dao, array(&$query, 'col')));
    }

    /**
     * Test that result_cell() returns an empty string if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_cell
     */
    public function testResultCellReturnsEmptyStringIfQueryHasNoResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->reflection_dao->getMethod('result_cell');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query, 'col'));

        $this->assertEquals('', $result);
    }

    /**
     * Test that result_cell() returns a value if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_cell
     */
    public function testResultCellReturnsValueIfQueryHasResults()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = 'value';

        $query->expects($this->once())
              ->method('result_cell')
              ->will($this->returnValue($query_result));

        $method = $this->reflection_dao->getMethod('result_cell');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, array(&$query, 'col'));

        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_retry() returns the same result query if there is no deadlock.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReturnsQueryInNoDeadlock()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_deadlock')
              ->will($this->returnValue(FALSE));

        $method = $this->reflection_dao->getMethod('result_retry');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, [$query]);

        $this->assertSame($result, $query);
    }

    /**
     * Test that result_retry() re-executes the query if there is a deadlock.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReExecutesQueryInDeadlock()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->at(0))
              ->method('has_deadlock')
              ->will($this->returnValue(TRUE));

        $query->expects($this->at(1))
              ->method('query')
              ->will($this->returnValue('sql_query'));

        $this->db->expects($this->once())
                 ->method('query')
                 ->with('sql_query')
                 ->will($this->returnValue($query));

        $method = $this->reflection_dao->getMethod('result_retry');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, [$query, 1]);

        $this->assertSame($result, $query);
    }

    /**
     * Test that result_retry() re-executes the query if there is a deadlock more than once.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReExecutesQueryInDeadlockMoreThanOnce()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->at(0))
              ->method('has_deadlock')
              ->will($this->returnValue(TRUE));

        $query->expects($this->at(1))
              ->method('query')
              ->will($this->returnValue('sql_query'));

        $this->db->expects($this->once())
                 ->method('query')
                 ->with('sql_query')
                 ->will($this->returnValue($query));

        $query->expects($this->at(2))
              ->method('has_deadlock')
              ->will($this->returnValue(FALSE));

        $method = $this->reflection_dao->getMethod('result_retry');
        $method->setAccessible(TRUE);

        $result = $method->invokeArgs($this->dao, [$query, 2]);

        $this->assertSame($result, $query);
    }

}

?>
