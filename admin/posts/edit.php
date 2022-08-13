<?php
include_once "../../path.php";
include SITE_ROOT."/app/controllers/posts.php";
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <!--    Bootstrap5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- google fonts comfortaa-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!--    Font Awasome - сервис иконок-->
    <script src="https://kit.fontawesome.com/b4b9c9d1d0.js" crossorigin="anonymous"></script>
    <!--    кастумные стили-->
    <link rel="stylesheet" href="../../assets/css/admin.css">

</head>
<body>
<!--header-->
<?php
include("../../app/include/adminheader.php");
?>

<div class="container">
    <div class="row">

        <!--SIDEBAR-->
        <?php include("../../app/include/admin-sidebar.php");
        ?>

        <div class="posts col-9">
            <div class="button row">
                <!--                <a href="create.php" class="col-2 btn btn-success">Add posts</a>-->
                <a href="index.php" class="col-2 btn btn btn-warning">Редактировать</a>
            </div>
            <h2>Редактирование статьи</h2>
            <div class="row add-post">
                <form action="edit.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3 col-12 col-md-12 err">
                        <!--ВЫВОД МАССИВА С ОШИБКОЙ-->
                        <?php include SITE_ROOT."/app/helpers/error_info.php";?>

                    </div>
                    <input type="hidden" name="id" value="<?=$id?>">
                    <input type="hidden" name="old_topic_id" value="<?=$topic_id?>">
                    <input type="hidden" name="old_img" value="<?=$img?>">
                    <input type="hidden" name="old_status" value="<?=$status?>">
                    <div class="col mb-4">
                        <label for="post-name" class="form-label">Название статьи</label>
                        <input value="<?=$title?>" placeholder="Введите название статьи"name="title" id="post-name"
                        type="text"
                               class="form-control"
                               aria-label="Название статьи">
                    </div>
                    <div class="col">
                        <label for="editor" class="form-label">Текст статьи</label>
                        <textarea id="editor" placeholder="Введите текст статьи" name="content" class="form-control"
                                  id="content"
                                  rows="6"
                        ><?=$content?></textarea>
                    </div>
                    <div class="input-group col mb-4 mt-4">
                        <input type="file" name="img" class="form-control" id="post-pic-upload">
                        <label class="input-group-text"  for="post-pic-upload">Добавить обложку</label>
                    </div>
                    <select class="form-select mb-4" name="topic_id" aria-label="Default select example">

                        <option selected disabled>Выбрать категорию поста:</option>
                        <?php foreach($topicsArr as $val):?>
                            <option value="<?=$val['id'];?>"
                                    <?php if($val['id'] === $topic_id):?>selected<?php endif;?>><?=$val['name']?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="col col-6">
                        <input id="status" type="checkbox" name="status" <?php if($status === '1'):?> checked <?php
                        endif;?>>
                        <label for="status" class="form-label">Опубликовать сразу</label>
                    </div>
                    <div class="col col-6">
                        <button name="edit-post-btn" class="btn btn-primary" type="submit">Сохранить изменения</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php
include("../../app/include/footer.php");
?>

<!--BOOTSTRAP-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<!--CKEDITOR - визуальный редактор к текстовому полю-->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script src="../../assets/js/script.js"></script>

</body>
</html>