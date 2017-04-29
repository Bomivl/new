<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test</title>
        <link rel="stylesheet" href="/style.css">


    </head>
    <body>
        <div id="body">
            <div id="list">
                <ul>
                    <li><a href='index.php'>Главная</a></li>
                    <li><a href='index.php?id=add'>Создать пользователя</a></li>
                    <li><a href='index.php?id=get'>Получить данные</a></li>
                    <li><a href='index.php?id=update'>Изменить</a></li>

                </ul>
            </div>
            <?php
            switch ($action) {
                case 'add':
                    include_once __DIR__ . '/addUser.php';
                    break;
                case 'get':
                    include_once __DIR__ . '/getUserData.php';
                    break;
                case 'update':
                    include_once __DIR__ . '/updateData.php';
                    break;
                default:
                    break;
            }
            ?>


        </div> 
        <?php
        if (isset($result)) {
            echo "<ul class='border'>";
            if (is_array($result)) {
                foreach ($result as $k => $v) {
                    echo "<li>$k = $v</li>";
                }
            } else {
                echo "<li>$result</li>";
            }
            echo "</ul>";
        }
        ?>
    </body>

</html>

