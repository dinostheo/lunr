<?php

/**
 * This file contains the file existence flags.
 *
 * PHP Version 5.4
 *
 * @category   Enums
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem;

/**
 * Filesystem file existence flags.
 *
 * @category   Enums
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 */
class FileFlags
{

    /**
     * FILE exists and is block special.
     * @var String
     */
    const BLOCK_SPECIAL_FILE = 'b';

    /**
     * FILE exists and is character special.
     * @var String
     */
    const CHAR_SPECIAL_FILE = 'c';

    /**
     * FILE exists and is a directory.
     * @var String
     */
    const DIRECTORY_FILE = 'd';

    /**
     * FILE exists.
     * @var String
     */
    const FILE_EXISTS = 'e';

    /**
     * FILE exists and is a regular file.
     * @var String
     */
    const REGULAR_FILE = 'f';

    /**
     * FILE exists and is set-group-ID.
     * @var String
     */
    const SET_GROUP_ID_FILE = 'g';

    /**
     * FILE exists and is owned by the effective group ID.
     * @var String
     */
    const EFFECTIVE_GROUP_FILE = 'G';

    /**
     * FILE exists and is a symbolic link.
     * @var String
     */
    const SYMBOLIC_LINK_FILE = 'h';

    /**
     * FILE exists and is owned by the effective user ID.
     * @var String
     */
    const EFFECTIVE_USER_FILE = 'O';

    /**
     * FILE exists and is a named pipe.
     * @var String
     */
    const NAMED_PIPE_FILE = 'p';

    /**
     * FILE exists and read permission is granted.
     * @var String
     */
    const READABLE_FILE = 'r';

    /**
     * FILE exists and has a size greater than zero.
     * @var String
     */
    const GT_ZERO_SIZE_FILE = 's';

    /**
     * FILE exists and is a socket.
     * @var String
     */
    const SOCKET_FILE = 'S';

    /**
     * File descriptor is opened on a terminal.
     * @var String
     */
    const TERMINAL_FILE_DESCRIPTOR = 't';

    /**
     * FILE exists and its set-user-ID bit is set.
     * @var String
     */
    const SET_USER_ID_FILE = '-u';

    /**
     * FILE exists and write permission is granted.
     * @var String
     */
    const WRITABLE_FILE = 'w';

    /**
     * FILE exists and execute permission is granted.
     * @var String
     */
    const EXECUTABLE_FILE = 'x';

    /**
     * FILE exists and has been modified since it was last read.
     * @var String
     */
    const MODIFIED_SINCE_LAST_READ = 'N';

}

?>
