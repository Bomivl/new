<?php

namespace MyClass;

class Db
{

    private $cnn;

    public function __construct()
    {
        $this->cnn = new \PDO("mysql:host=127.0.0.1;dbname=newTest", 'root');
    }

    /**
     * Создание таблици, если она не существует.
     * @throws Exception
     * @return void
     */
    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS test(
                    id INT NOT NULL AUTO_INCREMENT,
                    name varchar(100) NOT NULL default '',
                    email varchar(200),
                    PRIMARY KEY(id)
                    )";
        $res = $this->cnn->exec($sql);
        if ($res === false) {
            throw new \Exception("Таблица не создана");
        }
    }

    /**
     * Получения пользователя по id
     * @param integer $id
     * @return array 
     */
    public function getUserData($id)
    {
        $id = (int) $id;
        $sql = 'SELECT * FROM test 
                    WHERE id =' . $id;
        $res = $this->cnn->query($sql)->fetch(\PDO::FETCH_ASSOC);
        if ($res === false) {
            throw new \Exception("Пользователя с таким id не существует ");
        }
        return $res;
    }

    /**
     * Добавление нового пользователя в БД
     * @param string $name optional
     * @param string $email optional
     * @return string
     */
    public function addUser($name = '', $email = '')
    {
        $sql = "INSERT INTO test(name, email) 
                    VALUES(:name, :email)";
        $res = $this->cnn->prepare($sql)->execute([':name' => $name, ':email' => $email]);
        if ($res === false) {
            throw new \Exception("Ошибка добавления");
        }
        if ($name === '')
            return 'Пользователь без имени добавлен';
        return 'Пользователь с именем ' . $name . ' добавлен';
    }

    /**
     * Обновление данных пользователя в БД по его ID
     * @param int $id
     * @param string $name
     * @param string $email
     * @return boolean
     */
    public function updateData(int $id, $name, $email)
    {
//        if ($this->getUserData($id) === false) {
//            throw new \Exception("Ошибка id");
//        }
        $sql = "UPDATE test 
                SET name=:name, email=:email
                WHERE id=:id";
        $res = $this->cnn->prepare($sql)->execute([':id' => $id, ':name' => $name, ':email' => $email]);
        if ($res === false) {
            throw new \Exception("Ошибка изменения");
        }
        return true;
    }

}
