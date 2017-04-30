<?php
error_reporting(-1);
include __DIR__ . '/autoload.php';

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
 * @todo заменить
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
        try {
            switch ($action) {
                case 'add':
                    $result = $test->addUser($name, $email);
                    break;
                case 'get':
                    $result = $test->getUserData($id);
                    break;
                case 'update':
                    $updateData = $test->updateData($id, $name, $email);
                    if ($updateData)
                        $result = $test->getUserData($id);
                    break;
                default:
                    break;
            }
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
    }
} else {
    $action = '';
}
include __DIR__ . '/Templates/index.php';