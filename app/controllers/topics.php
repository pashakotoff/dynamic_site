<?php

include_once __DIR__."/../database/database.php";
$errMsgs = [];

//ОТОБРАЖЕНИЕ СПИСКА КАТЕГОРИЙ
$topicsArr = selectAll('topics');

$id = '';
$name = '';
$description = '';

//ФОРМА СОЗДАНИЯ КАТЕГОРИИ
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add-topic-btn'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    //Проверки формы
    printData(mb_strlen($name, 'utf-8'));
    if($name === '' || $description === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    }
    if (mb_strlen($name, 'utf-8') <= 2) {
        echo "Прошел проверку меньше двух символов";
        array_push($errMsgs, 'Имя топика должно быть больше двух символов!');
    }
    if (selectOne('topics', ['name'=>"$name"])) {
        array_push($errMsgs, "Категория с названием ".$name." уже существует");
    }

    //Если нет ошибок, то отправляем данные в БД
    if(empty($errMsgs)) {
            $topic = [
                'name' => $name,
                'description' => $description
            ];

            $id = insert('topics', $topic);
            $topic_db = selectOne("topics", ['id'=>$id]);
            header("location: ". BASE_URL."admin/topics/index.php");
    }

} else {
    $name = '';
    $description = '';
};



//РЕДАКТИРОВАНИЕ КАТЕГОРИИ

//Заполняем поля
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectOne('topics', ['id'=>$id]);
    $name = $topic['name'];
    $description = $topic['description'];
}


//Внесение изменений при нажатии на кнопку редактирования
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit-topic-btn'])) {
    $description = trim($_POST['description']);
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);

    //Проверки формы
    if ($name === '' || $description === '') {
        array_push($errMsgs, 'Поля не должн быть пустыми');
    }
    if (mb_strlen($name, 'utf-8') < 2) {
        array_push($errMsgs, "Имя топика должно быть больше двух символов");
    }

    //Если нет ошибок - отправляем форму в БД
    if(empty($errMsgs)) {
        $topic = [
            'name' => $name,
            'description' => $description
        ];
        update('topics', $id, $topic);
        $topic_db = selectOne("topics", ['id' => $id]);
        header("location: " . BASE_URL . "admin/topics/index.php");
    }
}

//Удаление топика
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    delete('topics', $id);
    header("location: " . BASE_URL . "admin/topics/index.php");
}


