<?php
include 'path.php';
include SITE_ROOT."/app/database/database.php";
$topic_id = $_GET['topic_id'];
$topic = selectOne('topics', ['id'=>$topic_id])['name'];
$page = isset($_GET['page'])? $_GET['page']:1;
$posts = selectDataForCategoryWithLimit($topic_id,$limitOfPostsPerPage,$page);
$numOfActivePosts = countNumOfActivePostsWithCategory($topic_id);

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
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!--header-->
<?php
include("app/include/header.php");
?>



<!--БЛОК MAIN-->
<div class="container">
    <div class="content row">

        <!--    MAIN CONTENT-->
        <div class="main-content col-md-9">
            <h2>Результаты поиска по категории <strong>"<?php echo $topic ?>"</strong></h2>
            <?php if(empty($posts)):?>
                <p>К сожалению в категории<strong> "<?php echo $topic ?>"</strong> пока ничего нет</p>
            <?php endif ?>

            <!--СПИСОК ПОСТОВ-->
            <?php include SITE_ROOT . "/app/include/post_list.php" ?>
            <!--ПАГИНАЦИЯ-->
            <?php include SITE_ROOT . "/app/include/pagination.php" ?>
        </div>

        <!--SIDEBAR-->
        <?php include SITE_ROOT."/app/include/sidebar.php"; ?>

    </div>
</div><!--БЛОК MAIN-->


<!--FOOTER-->
<?php
include("app/include/footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>


</body>
</html>

