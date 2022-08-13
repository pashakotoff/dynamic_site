<?php

include_once __DIR__."/../database/database.php";

if(!$_SESSION) {
    header('location: '.BASE_URL."login.php");
}

//ОТОБРАЖЕНИЕ СПИСКА КАТЕГОРИЙ
$topicsArr = selectAll('topics');
$postsArr = selectAll('posts');
$postsAdm = selectAllPostsByUser();

//ОБНУЛЕНИЕ ПЕРЕМЕННЫХ
$errMsgs = [];
$errMsg = '';

$id = '';
$title = '';
$content = '';
$img ='';
$topic_id ='';


//ФОРМА СОЗДАНИЯ ЗАПИСИ/ПОСТА
//---------------------------
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add-post-btn'])) {
    //Корректировка переменных
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    if(array_key_exists('topic_id', $_POST)) {
        $topic_id = trim($_POST['topic_id']);
    }
    if(trim(@ $_POST['status'] === 'on')) {
        $status = 1;
    } else {
        $status = 0;
    }

    //Поиск ошибок при заполнении формы
    if($title === '' || $content === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    } else {
        if (mb_strlen($title, 'utf-8') < 5) {
            array_push($errMsgs, 'Название статьи должно быть больше 5 символов');
        }
        if ($topic_id === '') {
            array_push($errMsgs, 'Не выбрана категория поста');
        }
    }

    //Добавление картинок и поиск ошибок добавления картинок (только если нет ошибок)
    if(empty($errMsgs)) {

        if(empty($_FILES['img']['name'])){
            array_push($errMsgs, "Ошибка получения картинки");
        } else {
            $imgName = time() . "_" . $_FILES['img']['name'];
            $tempImgFile = $_FILES['img']['tmp_name'];
            $fileType = $_FILES['img']['type'];
            $destination = ROOT_PATH . "/assets/images/posts/" . $imgName;
            if (strpos($fileType, 'image') === false) {
                array_push($errMsgs, "Загружаемый файл не является изображением");
            } else {
                $result = move_uploaded_file($tempImgFile, $destination);
                if ($result === false) {
                    array_push($errMsgs, "Ошибка загрузки картинки!");
                } else {
                    $_POST['img'] = $imgName;
                    if (empty($_POST['img'])) {
                        array_push($errMsgs, 'Не добавлена картинка');
                    } else {
                        $img = trim($_POST['img']);
                    }
                }
            }
        }
    }

    //Если нет ошибок - отправляем на сервер
    if(empty($errMsgs)) {
        $id_user = $_SESSION['id'];
        $post = [
            'id_user' => $id_user,
            'title' => $title,
            'content' => $content,
            'topic_id' => $topic_id,
            'img' => $img,
            'status' => $status
        ];
        $id = insert('posts', $post);
        $postFromDb = selectOne("posts", ['id'=>$id]);
        header("location: ". BASE_URL."admin/posts/index.php");
    }

} else {
    $title = '';
    $content = '';
};
//----- КОНЕЦ СКРИПТА СОЗДАНИЯ ПОСТА -----//


//РЕДАКТИРОВАНИЕ ПОCТА
//---------------------
//Заполняем поля при нажатии на кнопку редактирования
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = selectOne('posts', ['id'=>$id]);
    $title = $post['title'];
    $content = $post['content'];
    $topic_id = $post['topic_id'];
    $img = $post['img'];
    $status = $post['status'];
}

//Внесение изменений при нажатии на кнопку редактирования
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit-post-btn'])) {
    //Заполнение переменных
    $id = trim($_POST['id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    if(array_key_exists('topic_id', $_POST)) {
        $topic_id = trim($_POST['topic_id']);
    } else {
        $topic_id = trim($_POST['old_topic_id']);
    }
    if(!array_key_exists('img', $_POST)) {
        $_POST['img'] = trim($_POST['old_img']);
    }
    if(trim(@ $_POST['status'] === 'on')) {
        $status = 1;
    } else {
        $status = 0;
    }

    //Поиск ошибок при заполнении формы
    if($title === '' || $content === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    } else {
        if (mb_strlen($title, 'utf-8') < 5) {
        array_push($errMsgs, 'Название статьи должно быть больше 5 символов');
        }
        if ($topic_id === '') {
            array_push($errMsgs, 'Не выбрана категория поста');
        }
    }

    //Обновление картинок
    if(empty($errMsgs)){
        if(empty($_FILES['img']['name'])){
            $img = $_POST['img'];
        } else {
            $imgName = time() . "_" . $_FILES['img']['name'];
            $tempImgFile = $_FILES['img']['tmp_name'];
            $fileType = $_FILES['img']['type'];
            $destination = ROOT_PATH . "/assets/images/posts/" . $imgName;
            if (strpos($fileType, 'image') === false) {
                array_push($errMsgs, "Загружаемый файл не является изображением");
            } else {
                $result = move_uploaded_file($tempImgFile, $destination);
                if ($result === false) {
                    array_push($errMsgs, "Ошибка загрузки картинки!");
                } else {
                    $_POST['img'] = $imgName;
                    if (empty($_POST['img'])) {
                        array_push($errMsgs, 'Не добавлена картинка');
                    } else {
                        $img = trim($_POST['img']);
                    }
                }
            }
        }
    }

    //Если проверка проведена успешна - отправляем форму в БД
    if(empty($errMsgs)) {
        $post = [
            'title' => $title,
            'content' => $content,
            'img' => $img,
            'topic_id' => $topic_id,
            "status" => $status

        ];
        update('posts', $id, $post);
        $topic_db = selectOne("topics", ['id' => $id]);
        header("location: " . BASE_URL . "admin/posts/index.php");
    }
}
//----- КОНЕЦ СКРИПТА РЕДАКТИРОВАНИЯ ПОСТА -----//

//КНОПКИ УПРАВЛЕНИЯ
//--------------------
//Кнопка удалить
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $post = selectOne('posts', ['id'=>$id]);
    $postImg = $post['img'];
    $imgFile = ROOT_PATH."/assets/images/posts/".$postImg;
    $res = unlink($imgFile);
    delete('posts', $id);
    header("location: " . BASE_URL . "admin/posts/index.php");
}

//Кнопка отменить публикацию
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['unpub_id'])) {
    $id = $_GET['unpub_id'];
    update('posts', $id, ['status'=> 0]);
    header("location: " . BASE_URL . "admin/posts/index.php");
}

//Кнопка опубликовать
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    update('posts', $id, ['status'=> 1]);
    header("location: " . BASE_URL . "admin/posts/index.php");
}
