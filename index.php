<?php

error_reporting(-1);
//Автозагрузка
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        include $file;
    }
});

use MyClass\Db;

try {
    $test = new Db();
    $test->createTable();
} catch (PDOException $e) {
    exit($e->getMessage());
} catch (Exception $e) {
    exit($e->getMessage());
}
/**
 * @todo заменить на более 'адекватное' решение стр. 25 - 61
 */
if (isset($_GET['id'])) {
    $action = strip_tags($_GET['id']);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name']))
            $name = trim(strip_tags($_POST['name']));
        if (isset($_POST['email']))
            $email = trim(strip_tags($_POST['email']));
        if (isset($_POST['id']))
            $id = (int) $_POST['id'];
        switch ($action) {
            case 'add':
                try {
                    $result = $test->addUser($name, $email);
                } catch (Exception $e) {
                    $result = $e->getMessage();
                }
                break;
            case 'get':
                try {
                    $result = $test->getUserData($id);
                } catch (Exception $e) {
                    $result = $e->getMessage();
                }
                break;
            case 'update':
                try {
                    $updateData = $test->updateData($id, $name, $email);
                    if ($updateData) {
                        $result = $test->getUserData($id);
                    }
                } catch (Exception $e) {
                    $result = $e->getMessage();
                }
                break;
            default:
                break;
        }
    }
} else {
    $action = '';
}
include __DIR__ . '/Templates/index.php';




