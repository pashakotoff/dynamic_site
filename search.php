<?php
include 'path.php';
include SITE_ROOT."/app/database/database.php";

$page = isset($_GET['page'])? $_GET['page']:1;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];
} elseif ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['search_term']) ) {
    $searchTerm = $_GET['search_term'];
}
else {
    echo "Критическая ошибка поиска!";
}
$posts = searchInTitleAndContentWithLimit($searchTerm, $limitOfPostsPerPage, $page);
$numOfActivePosts = countNumOfActivePostsBySearchTerm($searchTerm);

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
            <div class="main-content col-md-12">
                <h2>Результаты поиска по запросу <strong>"<?php echo $searchTerm ?>"</strong></h2>
                <?php if(empty($posts)):?>
                    <form action="search.php" method="post">
                        <p class="">К сожалению по запросу <strong>"<?php echo $searchTerm ?>"</strong> ничего
                            не
                            найдено,
                            попробуйте
                            изменить
                            запрос</p>
                        <input type="text" name="search_term" class="text-input" placeholder="поиск">
                    </form>

                <?php endif ?>

                <!--СПИСОК ПОСТОВ-->
                <?php include SITE_ROOT . "/app/include/post_list.php" ?>
                <!--ПАГИНАЦИЯ-->
                <?php include SITE_ROOT . "/app/include/pagination.php" ?>

            </div>

        </div>
    </div><!--БЛОК MAIN-->

    <?php
    include("app/include/footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"></script>


</body>
</html>


<!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"-->
<!--        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"-->
<!--        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"-->
<!--        crossorigin="anonymous"></script>-->
