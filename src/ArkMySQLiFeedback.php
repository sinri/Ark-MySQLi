<?php
/**
 * Created by PhpStorm.
 * User: sinri
 * Date: 2019-03-29
 * Time: 21:46
 */

namespace sinri\ark\database\mysqli;

/**
 * Class ArkMySQLiFeedback
 * @package sinri\ark\database\mysqli
 * @since 1.1
 */
class ArkMySQLiFeedback
{
    /**
     * @var string
     */
    public $info;
    /**
     * @var int
     */
    public $affected_rows;
    /**
     * @var int
     */
    public $insert_id;
    /**
     * @var int
     */
    public $errno;
    /**
     * @var string
     */
    public $error;
    /**
     * @var int
     */
    public $warning_count;
    /**
     * @var \mysqli_warning[]
     */
    public $warnings;
}