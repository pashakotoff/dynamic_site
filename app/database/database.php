<?php
session_start();
require 'connect.php';

//ОБЩИЕ ПЕРЕМЕННЫЕ (НАСТРОЙКИ)
$titleLength = 65;
$contentLength = 300;
$adminCommentsLength = 20;
$adminPostTitleLength = 52;
$titleSliderLength = 60;
$limitOfPostsPerPage = 2;

//ОБЩИЕ ФУНКЦИИ
//Универсальная функция печати
function printData($val) {
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}

function printDataAndDie($val) {
    echo "<pre>";
    print_r($val);
    echo "</pre>";
    exit();
}

//Укарачивает текст в соостветствии с параметрами для вставки в HTML
function textShortener($postArr, $datakey, $length) {
    if(mb_strlen($postArr[$datakey], 'UTF-8') >$length) {
        echo mb_substr($postArr[$datakey], 0, $length) ."...";
    } else {
        echo $postArr[$datakey];
    }
}

//ФУНКЦИИ БД
function dbCheckError($query) {
    $errInfo = $query->errorInfo();
    if($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    } return true;
}


//Запрос на получение данных с одной таблице
function selectAll($table, $params=[]) {
    global $pdo;
    $sql = "SELECT * FROM dynamic_site.$table";

    if(!empty($params)) {
        $i = 0;
        foreach ($params as $key => $val) {
            if(!is_numeric($val)) {
                $val = "'" . $val . "'";
            }
            if($i === 0) {
                $sql = $sql . " WHERE $key = $val";
            } else {
                $sql = $sql . " AND $key = $val";
            } $i++;
        }
    }
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//Запрос на получение выбранной строки с одной таблицы
function selectOne($table, $params=[]) {
    global $pdo;
    $sql = "SELECT * FROM dynamic_site.$table";

    if(!empty($params)) {
        $i = 0;
        foreach ($params as $key => $val) {
            if(!is_numeric($val)) {
                $val = "'" . $val . "'";
            }
            if($i === 0) {
                $sql = $sql . " WHERE $key = $val";
            } else {
                $sql = $sql . " AND $key = $val";
            } $i++;
        }
    }
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}
$params = [
    'admin' => 0,
    'user_name' => 'pashakotoff'
];

//Запись данных в бд
function insert($table,$data) {
    global $pdo;
    $i = 0;
    $keyData = '';
    $valData = '';
    foreach ($data as $key => $val) {
        if($i == count($data) - 1) {
            $keyData = $keyData . $key;
            $valData = $valData . "'".$val."'";
        } else {
        $keyData = $keyData . $key.', ';
        $valData = $valData . "'".$val."', ";
        }
        $i++;
    }
    $sql = "INSERT INTO dynamic_site.$table($keyData) VALUES ($valData)";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $pdo->lastInsertId();//возвращаем id добалвенной записи
}

//Обновление строки
function update($table, $id, $data) {
    global $pdo;
    $i = 0;
    $updateData = '';
    foreach ($data as $key => $val) {
        if($i == count($data) - 1) {
            $updateData = $updateData. $key . "='" .$val."'";
        } else {
            $updateData = $updateData. $key . "='" .$val . "',";

        }
        $i++;
    }
    $sql = "UPDATE dynamic_site.$table SET " . $updateData . " ". "WHERE id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

//Удаление строки
function delete($table, $id) {
    global $pdo;
    $sql = "DELETE FROM dynamic_site.$table WHERE id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

$arrData = [
    'admin' => '0',
    'user_name' => 'kostya',
    'email' => 'fdsfdsf@fdsdsf.ru',
    'password' => '31jndfb32',
];


//Выборка записей
function selectAllPostsByUser() {
    global $pdo;
    $sql = "SELECT 
       pt.id,
       pt.title,
       pt.img, 
       pt.content,
       pt.status,
       pt.topic_id,
       pt.created,
       ut.user_name
    FROM dynamic_site.posts AS pt JOIN dynamic_site.users AS ut ON pt.id_user = ut.id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//Выборка записей для слайдера
function selectDataForSlider() {
    global $pdo;
    $sql = "SELECT * FROM dynamic_site.posts AS pt WHERE status=1 AND topic_id=25";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}


//Поиск по заголовкам и содержимому с учетом пагинации
function searchInTitleAndContentWithLimit($searchTerm, $limitOfPostsPerPage, $page) {
    $searchTerm = trim(strip_tags(stripcslashes(htmlspecialchars($searchTerm))));
    $offset = $limitOfPostsPerPage * ($page-1);
    global $pdo;
    $sql = "SELECT pt.*, ut.user_name
    FROM dynamic_site.posts AS pt
    JOIN dynamic_site.users AS ut 
    ON pt.id_user = ut.id 
    WHERE (pt.status = 1)
    AND (pt.title LIKE '%$searchTerm%' OR pt.content LIKE '%$searchTerm%')
    LIMIT $limitOfPostsPerPage OFFSET $offset";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//Выбор отдельного поста по ID с именем автора
function selectSinglePostWithAuthorName($id) {
    global $pdo;
    $sql = "SELECT pt.*, ut.user_name FROM dynamic_site.posts AS pt JOIN dynamic_site.users AS ut ON pt.id_user = ut.id WHERE pt.id=$id ";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}



//Выборка постов на главную (пагинация)
function selectDataForIndexWithLimit($limitOfPostsPerPage, $page) {
    $offset = $limitOfPostsPerPage * ($page-1);
    global $pdo;
    $sql = "SELECT pt.*, ut.user_name 
    FROM dynamic_site.posts AS pt 
    JOIN dynamic_site.users AS ut
    ON pt.id_user = ut.id 
    WHERE pt.status=1
    LIMIT $limitOfPostsPerPage
    OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function selectDataForCategoryWithLimit($topic_id, $limitOfPostsPerPage, $page) {
    $offset = $limitOfPostsPerPage * ($page-1);
    global $pdo;
    $sql = "SELECT pt.*, ut.user_name 
    FROM dynamic_site.posts AS pt 
    JOIN dynamic_site.users AS ut
    ON pt.id_user = ut.id 
    WHERE pt.status=1 AND pt.topic_id=$topic_id
    LIMIT $limitOfPostsPerPage
    OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function selectDataForAuthorWithLimit($author_id, $limitOfPostsPerPage, $page) {
    $offset = $limitOfPostsPerPage * ($page-1);
    global $pdo;
    $sql = "SELECT pt.*, ut.user_name 
    FROM dynamic_site.posts AS pt 
    JOIN dynamic_site.users AS ut
    ON pt.id_user = ut.id 
    WHERE pt.status=1 AND pt.id_user=$author_id
    LIMIT $limitOfPostsPerPage
    OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}


function countNumOfActivePosts() {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM dynamic_site.posts AS pt WHERE pt.status=1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}

function countNumOfActivePostsWithCategory($topic_id) {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM dynamic_site.posts AS pt WHERE pt.status=1 AND pt.topic_id = $topic_id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}

function countNumOfActivePostsByAuthor($author_id) {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM dynamic_site.posts AS pt WHERE pt.status=1 AND pt.id_user = $author_id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}

function countNumOfActivePostsBySearchTerm($searchTerm) {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM dynamic_site.posts AS pt 
    WHERE (pt.status=1) AND (pt.title LIKE '%$searchTerm%' OR pt.content LIKE '%$searchTerm%')";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}