<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/7
 * Time: 13:47
 */

namespace sinri\ark\database\mysqli;


use sinri\ark\core\ArkLogger;

class ArkMySQLi
{
    protected $logger;
    protected $config;
    /**
     * @var \mysqli
     */
    protected $instanceOfMySQLi;

    public function __construct(ArkMySQLiConfig $config)
    {
        $this->instanceOfMySQLi = null;
        $this->logger = ArkLogger::makeSilentLogger();
        $this->config = $config;
    }

    /**
     * @return ArkMySQLiConfig
     */
    public function getConfig(): ArkMySQLiConfig
    {
        return $this->config;
    }

    /**
     * @param ArkMySQLiConfig $config
     */
    public function setConfig(ArkMySQLiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return \mysqli|null
     */
    public function getInstanceOfMySQLi()
    {
        return $this->instanceOfMySQLi;
    }

    /**
     * @throws \Exception
     */
    public function connect()
    {
        if (!is_a($this->config, ArkMySQLiConfig::class)) {
            throw new \Exception("Ark MySQLi Config Lack");
        }
        $this->instanceOfMySQLi = new \mysqli(
            $this->config->host,
            $this->config->username,
            $this->config->password,
            $this->config->database,
            intval($this->config->port, 10)
        );
        if ($this->instanceOfMySQLi->connect_errno) {
            throw new \Exception("MySQLi Connect failed: " . $this->instanceOfMySQLi->connect_error);
        }

        // 设置数据库编码
        $this->instanceOfMySQLi->set_charset($this->config->charset);

        if (!empty($this->config->database) && !$this->instanceOfMySQLi->select_db($this->config->database)) {
            throw new \Exception("MySQLi select database failed: " . $this->instanceOfMySQLi->error);
        }
    }

    /**
     * Close Connection
     */
    public function closeConnection()
    {
        if ($this->instanceOfMySQLi) {
            $this->instanceOfMySQLi->close();
        }
        $this->instanceOfMySQLi = null;
    }

    /**
     * @since 1.1
     * @return ArkMySQLiFeedback
     */
    public function getLastFeedback()
    {
        $feedback = new ArkMySQLiFeedback();
        $feedback->info = $this->instanceOfMySQLi->info;
        $feedback->affected_rows = $this->instanceOfMySQLi->affected_rows;
        $feedback->insert_id = $this->instanceOfMySQLi->insert_id;
        $feedback->errno = $this->instanceOfMySQLi->errno;
        $feedback->error = $this->instanceOfMySQLi->error;
        $feedback->warning_count = $this->instanceOfMySQLi->warning_count;
        $feedback->warnings = [];

        if ($feedback->warning_count > 0) {
            $w = $this->instanceOfMySQLi->get_warnings();
            do {
                $feedback->warnings[] = $w;
            } while ($w->next());
        }

        return $feedback;
    }
}