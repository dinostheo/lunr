<?php

/**
 * Physical filesystem access class.
 *
 * PHP Version 5.4
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem;

use Lunr\Gravity\DataAccessObjectInterface;
use DirectoryIterator;
use RegexIterator;
use UnexpectedValueException;
use InvalidArgumentException;
use RuntimeException;
use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use SplFileObject;
use FilesystemIterator;

/**
 * Class to access a physical filesystem.
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class PhysicalFilesystemAccessObject implements DataAccessObjectInterface, FilesystemAccessObjectInterface
{

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
    }

    /**
     * Get a list of all non-dot directories in a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of directory in that directory
     */
    public function get_list_of_directories($directory)
    {
        $directories = array();

        if (is_bool($directory))
        {
            return $directories;
        }

        try
        {
            $dir = new DirectoryIterator($directory);
            foreach ($dir as $file)
            {
                if (!$file->isDot() && $file->isDir())
                {
                    $directories[] = $dir->getFilename();
                }
            }
        }
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $directory, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
        }

        return $directories;
    }

    /**
     * Get a list of all non-dot files in a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of files in that directory
     */
    public function get_list_of_files($directory)
    {
        $files = array();

        if (is_bool($directory))
        {
            return $files;
        }

        try
        {
            $dir = new DirectoryIterator($directory);
            foreach ($dir as $file)
            {
                if (!$file->isDot() && !$file->isDir())
                {
                    $files[] = $dir->getFilename();
                }
            }
        }
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $directory, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
        }

        return $files;
    }

    /**
     * Get a listing of the contents of a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of contents of that directory
     */
    public function get_directory_listing($directory)
    {
        $raw_results = scandir($directory, SCANDIR_SORT_NONE);

        return array_diff($raw_results, array('.', '..'));
    }

    /**
     * Find a file in a given directory.
     *
     * @param String $needle   Filename to look for
     * @param String $haystack Base directory to search in
     *
     * @return mixed $return Path of the file if found,
     *                       FALSE on failure
     */
    public function find_matches($needle, $haystack)
    {
        if (is_bool($needle) || is_bool($haystack))
        {
            return array();
        }

        try
        {
            $directory = new RecursiveDirectoryIterator($haystack);
            $iterator  = new RecursiveIteratorIterator($directory);
            $matches   = new RegexIterator($iterator, $needle, RecursiveRegexIterator::GET_MATCH);
        }
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $haystack, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
            return FALSE;
        }
        catch(InvalidArgumentException $invalid)
        {
            $context = [ 'message' => $invalid->getMessage() ];
            $this->logger->error('{message}', $context);
            return FALSE;
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
            return array();
        }

        return array_keys(iterator_to_array($matches));
    }

    /**
     * Get a SplFileObject for a given path.
     *
     * @param String $file Filepath
     * @param String $mode The mode in which to open the file. Default: readonly
     *
     * @return mixed $file SplFileObject instance for the path, FALSE on failure
     */
    public function get_file_object($file, $mode = 'r')
    {
        try
        {
            return is_bool($file) ? FALSE : new SplFileObject($file, $mode);
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
        catch(LogicException $logic)
        {
            $context = [ 'message' => $logic->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
    }

    /**
     * Get the contents of a given file.
     *
     * @param String $file Filepath
     *
     * @return mixed $contents Contents of the given file as String on success,
     *                         FALSE on failure
     */
    public function get_file_content($file)
    {
        return is_bool($file) ? FALSE : file_get_contents($file);
    }

    /**
     * Write contents into file.
     *
     * @param String  $file           Filepath
     * @param String  $contents       Contents to write
     * @param Boolean $append         Whether to append to an existing file or not
     * @param Boolean $exclusive_lock Whether to acquire an exclusive write lock for the file or not
     *
     * @return mixed $return Written bytes as integer on success,
     *                       FALSE on failure
     */
    public function put_file_content($file, $contents, $append = FALSE, $exclusive_lock = FALSE)
    {
        $flags = 0;

        if ($append === TRUE)
        {
            $flags = $flags | FILE_APPEND;
        }

        if ($exclusive_lock === TRUE)
        {
            $flags = $flags | LOCK_EX;
        }

        return is_bool($file) ? FALSE : file_put_contents($file, $contents, $flags);
    }

    /**
     * Recursively removes a directory and its contents.
     *
     * @param String $dir_path The directory path to be removed
     *
     * @return Boolean TRUE when directory is removed and FALSE in a failure.
     */
    public function rmdir($dir_path)
    {
        try
        {
            $directory = new RecursiveDirectoryIterator($dir_path, FilesystemIterator::SKIP_DOTS);
            $iterator  = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);

            foreach($iterator as $file)
            {
                if($file->isFile())
                {
                    unlink($file->getPathname());
                }
                else
                {
                    rmdir($file->getPathname());
                }
            }

            return rmdir($dir_path);
        }
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $dir_path, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't recurse on directory '{directory}': {message}", $context);
            return FALSE;
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
            return FALSE;
        }
    }

    /**
     * Checks if the given file exists and it matches the requested filetype criteria.
     *
     * @param Mixed  $file String filepath or resource
     * @param String $type The file type flag
     *
     * @return Boolean TRUE in file existence and match otherwise FALSE
     */
    public function file_exists($file, $type = 'e')
    {
        switch($type)
        {
            case FileFlags::FILE_EXISTS:
            case 'a':
                return file_exists($file);
            case FileFlags::BLOCK_SPECIAL_FILE:
                return filetype($file) === 'block';
            case FileFlags::CHAR_SPECIAL_FILE:
                return filetype($file) === 'char';
            case FileFlags::DIRECTORY_FILE:
                return filetype($file) === 'dir';
            case FileFlags::REGULAR_FILE:
                return filetype($file) === 'file';
            case FileFlags::SYMBOLIC_LINK_FILE:
            case 'L':
                return filetype($file) === 'link';
            case FileFlags::NAMED_PIPE_FILE:
                return filetype($file) === 'fifo';
            case FileFlags::READABLE_FILE:
                return is_readable($file) === TRUE;
            case FileFlags::WRITABLE_FILE:
                return is_writable($file) === TRUE;
            case FileFlags::EXECUTABLE_FILE:
                return is_executable($file) === TRUE;
            case FileFlags::SET_GROUP_ID_FILE:
                $gid = stat($file)['gid'];
                return isset($gid) && isset(posix_getgrgid($gid)['name']);
            case FileFlags::EFFECTIVE_GROUP_FILE:
                $gid = stat($file)['gid'];
                return isset($gid) && $gid === posix_getegid();
            case FileFlags::SET_USER_ID_FILE:
                $uid = stat($file)['uid'];
                return isset($uid) && isset(posix_getpwuid($uid)['name']);
            case FileFlags::EFFECTIVE_USER_FILE:
                $uid = stat($file)['uid'];
                return isset($uid) && $uid === posix_geteuid();
            case FileFlags::GT_ZERO_SIZE_FILE:
                $size = stat($file)['size'];
                return isset($size) && $size > 0;
            case FileFlags::TERMINAL_FILE_DESCRIPTOR:
                return posix_isatty($file);
            case FileFlags::MODIFIED_SINCE_LAST_READ:
                $stats = stat($file);
                return $stats['atime'] < $stats['mtime'];
            case FileFlags::SOCKET_FILE:
                return fstat($file)['mode'] === 140000;
            default:
                break;
        }

        return FALSE;
    }

}

?>
