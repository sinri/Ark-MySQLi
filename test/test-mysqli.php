<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/7
 * Time: 13:50
 */

$config_mysqli = new \sinri\ark\database\mysqli\ArkMySQLiConfig();

//require __DIR__ . '/config.php'; // to override $config_mysqli

$db = new \sinri\ark\database\mysqli\ArkMySQLi($config_mysqli);

try {
    $db->connect();

    $result = $db->getInstanceOfMySQLi()->query("SELECT * FROM ecshop.ecs_order_info LIMIT 2");
    \sinri\ark\core\ArkHelper::assertItem($result, 'result null', \sinri\ark\core\ArkHelper::ASSERT_TYPE_NOT_EMPTY);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    do {
        print_r($row);
    } while ($row = $result->fetch_array(MYSQLI_ASSOC));

    echo "DONE" . PHP_EOL;
} catch (Exception $e) {
    echo "ERR" . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
} finally {
    echo "FIN" . PHP_EOL;
    $db->closeConnection();
}
