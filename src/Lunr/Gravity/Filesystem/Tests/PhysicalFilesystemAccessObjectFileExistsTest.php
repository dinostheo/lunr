<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectFileExistsTest class.
 *
 * PHP Version 5.4
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;
use Lunr\Gravity\Filesystem\FileFlags;

/**
 * This class contains tests for the file_exists method.
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectFileExistsTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that file_exists() returns TRUE when file exists.
     *
     * @dataProvider fileExistsFlagProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenFileExists($flag)
    {
        $file = TEST_STATICS . '/Gravity/file1';

        $this->assertTrue($this->class->file_exists($file, $flag));
    }

    /**
     * Test that file_exists() returns FALSE when file does not exist.
     *
     * @dataProvider fileExistsFlagProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenFileDoesNotExist($flag)
    {
        $file = TEST_STATICS . '/Gravity/doesnotexist';

        $this->assertFalse($this->class->file_exists($file, $flag));
    }

    /**
     * Test that file_exists() returns TRUE when file exists and filetype matches.
     *
     * @dataProvider fileExistsFiletypeProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenFileExistAndFiletypeMatches($flag, $filetype)
    {
        $this->mock_function("filetype", "return '$filetype';");

        $this->assertTrue($this->class->file_exists('filepath', $flag));

        $this->unmock_function('filetype');
    }

    /**
     * Test that file_exists() returns TRUE when filetype does not match.
     *
     * @dataProvider fileExistsFiletypeProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenFiletypeDoesNotMatch($flag)
    {
        $this->mock_function("filetype", "return 'unknown';");

        $this->assertFalse($this->class->file_exists('filepath', $flag));

        $this->unmock_function('filetype');
    }

    /**
     * Test that file_exists() returns TRUE when permission checks are correct.
     *
     * @dataProvider fileExistsPermissionProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenPermissionsAreCorrect($flag, $function)
    {
        $this->mock_function("$function", "return TRUE;");

        $this->assertTrue($this->class->file_exists('filepath', $flag));

        $this->unmock_function("$function");
    }

    /**
     * Test that file_exists() returns FALSE when permission checks are wrong.
     *
     * @dataProvider fileExistsPermissionProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenPermissionsAreWrong($flag, $function)
    {
        $this->mock_function("$function", "return FALSE;");

        $this->assertFalse($this->class->file_exists('filepath', $flag));

        $this->unmock_function("$function");
    }


    /**
     * Test that file_exists() returns TRUE when group file id is set.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenGroupFileIdIsSet()
    {
        $this->mock_function("stat", "return ['gid' => 500];");
        $this->mock_function("posix_getgrgid", "return ['name' => 'Lunr Test'];");

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::SET_GROUP_ID_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_getgrgid');
    }

    /**
     * Test that file_exists() returns FALSE when group file id is not set.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenGroupFileIdIsNotSet()
    {
        $this->mock_function("stat", "return ['gid' => NULL];");
        $this->mock_function('posix_getgrgid', 'return [];');

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::SET_GROUP_ID_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_getgrgid');
    }

    /**
     * Test that file_exists() returns TRUE when file group is the effective.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenGroupFileIsTheEffectiveGroup()
    {
        $this->mock_function("stat", "return ['gid' => 500];");
        $this->mock_function('posix_getegid', 'return 500;');

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::EFFECTIVE_GROUP_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_getegid');
    }

    /**
     * Test that file_exists() returns FALSE when file group is not the effective.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenGroupFileIsNotTheEffectiveGroup()
    {
        $this->mock_function("stat", "return ['gid' => 500];");
        $this->mock_function('posix_getegid', 'return 517;');

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::EFFECTIVE_GROUP_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_getegid');
    }

    /**
     * Test that file_exists() returns TRUE when user file id is set.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenUserFileIdIsSet()
    {
        $this->mock_function("stat", "return ['uid' => 300];");
        $this->mock_function("posix_getpwuid", "return ['name' => 'testUser'];");

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::SET_USER_ID_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_getpwuid');
    }

    /**
     * Test that file_exists() returns FALSE when user file id is not set.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenUserFileIdIsNotSet()
    {
        $this->mock_function("stat", "return ['uid' => NULL];");
        $this->mock_function('posix_getpwuid', 'return [];');

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::SET_USER_ID_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_getpwuid');
    }

    /**
     * Test that file_exists() returns TRUE when file user is the effective.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenUserFileIsTheEffectiveUser()
    {
        $this->mock_function("stat", "return ['uid' => 300];");
        $this->mock_function('posix_geteuid', 'return 300;');

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::EFFECTIVE_USER_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_geteuid');
    }

    /**
     * Test that file_exists() returns FALSE when file user is not the effective.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenUserFileIsNotTheEffectiveUser()
    {
        $this->mock_function("stat", "return ['uid' => 300];");
        $this->mock_function('posix_geteuid', 'return 333;');

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::EFFECTIVE_USER_FILE));

        $this->unmock_function('stat');
        $this->unmock_function('posix_geteuid');
    }

    /**
     * Test that file_exists() returns TRUE when file size is greater than zero.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenFileSizeIsGreaterThanZero()
    {
        $file = TEST_STATICS . '/Gravity/file1';

        $this->assertTrue($this->class->file_exists($file, FileFlags::GT_ZERO_SIZE_FILE));
    }

    /**
     * Test that file_exists() returns FALSE when file size is not greater than zero.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenFileSizeIsNotGreaterThanZero()
    {
        $file = TEST_STATICS . '/Gravity/file2';

        $this->assertFalse($this->class->file_exists($file, FileFlags::GT_ZERO_SIZE_FILE));
    }


    /**
     * Test that file_exists() returns TRUE when file descriptor is a terminal file descriptor.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenFileDescriptorIsATerminalFileDescriptor()
    {
        $this->mock_function('posix_isatty', 'return TRUE;');

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::TERMINAL_FILE_DESCRIPTOR));

        $this->unmock_function('posix_isatty');
    }

    /**
     * Test that file_exists() returns TRUE when file descriptor is not a terminal file descriptor.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenFileDescriptorIsNotATerminalFileDescriptor()
    {
        $this->mock_function('posix_isatty', 'return FALSE;');

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::TERMINAL_FILE_DESCRIPTOR));

        $this->unmock_function('posix_isatty');
    }

    /**
     * Test that file_exists() returns TRUE when file is modified since last read.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenUserFileIsModifiedSinceLastRead()
    {
        $this->mock_function("stat", "return ['atime' => 1, 'mtime' => 2];");

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::MODIFIED_SINCE_LAST_READ));

        $this->unmock_function('stat');
    }

    /**
     * Test that file_exists() returns FALSE when file is not modified since last read.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenUserFileIsNotModifiedSinceLastRead()
    {
        $this->mock_function("stat", "return ['atime' => 2, 'mtime' => 1];");

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::MODIFIED_SINCE_LAST_READ));

        $this->unmock_function('stat');
    }

    /**
     * Test that file_exists() returns TRUE when file is a socket.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsTrueWhenUserFileIsAScoket()
    {
        $this->mock_function("fstat", "return ['mode' => 140000];");

        $this->assertTrue($this->class->file_exists('filepath', FileFlags::SOCKET_FILE));

        $this->unmock_function('fstat');
    }

    /**
     * Test that file_exists() returns FALSE when file is not a socket.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenUserFileIsNotASocket()
    {
        $this->mock_function("fstat", "return ['mode' => 170000];");

        $this->assertFalse($this->class->file_exists('filepath', FileFlags::SOCKET_FILE));

        $this->unmock_function('fstat');
    }

    /**
     * Test that file_exists() returns FALSE when file flag is unknown.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::file_exists
     */
    public function testFileExistsReturnsFalseWhenFileFlagIsUnkown()
    {
        $this->assertFalse($this->class->file_exists('filepath', 'unkown'));
    }


}

?>
