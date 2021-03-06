<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsInsertTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods that are used when building INSERT and REPLACE statements
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsInsertTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the SET part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_set
     */
    public function testInitialSet()
    {
        $method = $this->get_accessible_reflection_method('sql_set');

        $method->invokeArgs($this->class, [[ 'column1' => 'value1' ]]);

        $string = 'SET column1 = value1';

        $this->assertPropertyEquals('set', $string);
    }

    /**
     * Test specifying the SET part of a query incrementally.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_set
     */
    public function testIncrementalSet()
    {
        $method = $this->get_accessible_reflection_method('sql_set');

        $method->invokeArgs($this->class, [[ 'column1' => 'value1' ]]);
        $method->invokeArgs($this->class, [[ 'column2' => 'value2' ]]);

        $string = 'SET column1 = value1, column2 = value2';

        $this->assertPropertyEquals('set', $string);
    }

    /**
     * Test the sql_set() function when a value is NULL.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_set
     */
    public function testSetWithNullValue()
    {
        $method = $this->get_accessible_reflection_method('sql_set');

        $method->invokeArgs($this->class, [[ 'column1' => 'value1' ]]);
        $method->invokeArgs($this->class, [[ 'column2' => NULL ]]);

        $string = 'SET column1 = value1, column2 = NULL';

        $this->assertPropertyEquals('set', $string);
    }

    /**
     * Test specifying empty Values for a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testUndefinedValuesQueryPart()
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [ [] ]);

        $string = '';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying the Values part of a query.
     *
     * @param Array $values Array of insert values
     *
     * @dataProvider insertValuesProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testInitialValuesQueryPart($values)
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [ $values ]);

        $string = 'VALUES (value1, value2, value3)';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying the Values part of a query incrementally.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testIncrementalValues()
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [[ 'value1', 'value2', 'value3' ]]);

        $values   = [];
        $values[] = [ 'value4', 'value5', 'value6' ];
        $values[] = [ 'value7', 'value8', 'value9' ];

        $method->invokeArgs($this->class, [ $values ]);

        $string = 'VALUES (value1, value2, value3), (value4, value5, value6), (value7, value8, value9)';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying NULL values in the Values part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testNullValues()
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [[ 'value1', NULL, 'value3' ]]);

        $string = 'VALUES (value1, NULL, value3)';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying the column_names part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_column_names
     */
    public function testInitialColumnNames()
    {
        $method = $this->get_accessible_reflection_method('sql_column_names');

        $method->invokeArgs($this->class, [[ 'column1', 'column2', 'column3' ]]);

        $string = '(column1, column2, column3)';

        $this->assertPropertyEquals('column_names', $string);
    }

    /**
     * Test specifying the select_statement part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select_statement
     */
    public function testInitialSelectStatement()
    {
        $method = $this->get_accessible_reflection_method('sql_select_statement');

        $method->invokeArgs($this->class, [ 'SELECT * FROM table1' ]);

        $string = 'SELECT * FROM table1';

        $this->assertPropertyEquals('select_statement', $string);
    }

    /**
     * Test specifying the select_statement part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select_statement
     */
    public function testInvalidSelectStatement()
    {
        $method = $this->get_accessible_reflection_method('sql_select_statement');

        $method->invokeArgs($this->class, [ 'INSERT INTO table1' ]);

        $string = '';

        $this->assertPropertyEquals('select_statement', $string);
    }

    /**
     * Test specifying the INTO part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_into
     */
    public function testInitialInto()
    {
        $method = $this->get_accessible_reflection_method('sql_into');

        $method->invokeArgs($this->class, [ 'table1' ]);

        $string = 'INTO table1';

        $this->assertPropertyEquals('into', $string);
    }

    /**
     * Test specifying the INTO part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_into
     */
    public function testIncrementalInto()
    {
        $method = $this->get_accessible_reflection_method('sql_into');

        $method->invokeArgs($this->class, [ 'table1' ]);
        $method->invokeArgs($this->class, [ 'table2' ]);

        $string = 'INTO table2';

        $this->assertPropertyEquals('into', $string);
    }

}
?>
