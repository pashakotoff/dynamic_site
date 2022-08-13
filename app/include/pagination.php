<?php

$numOfPages = ceil($numOfActivePosts / $limitOfPostsPerPage);

//NEXT и PREVPAGE
$prevPage;
$nextPage;
if ($page == 1) {
    $prevPage = 1;
} else {
    $prevPage = $page - 1;
}

if ($page == $numOfPages) {
    $nextPage = $numOfPages;
} else {
    $nextPage = $page + 1;
}

//Условие подбора URL
$url = '';
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['topic_id'])) {
    $url = BASE_URL."category.php?topic_id=".$topic_id."&page=";
} elseif($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['author'])) {
    $url = BASE_URL."author.php?author=".$author_id."&page=";
} elseif($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['search_term']) || $_SERVER['REQUEST_METHOD'] === "GET"
    && isset($_GET['search_term']) ){
    $url = BASE_URL."search.php?search_term=".$searchTerm."&page=";
} else {
    $url = BASE_URL."index.php?page=";
}
?>

<!--Вставка HTML кода в зависимости от условий-->
<?php if($numOfPages <= 1):?>
    <div class="pagination"></div>
<?php else:?>
    <div class="pagination">
        <a href="<?=$url.$prevPage?>">«</a>
        <?php for($i=1; $i <= $numOfPages; $i++):?>
            <?php if($i == $page):?>
                <a class="active_page" href="<?=$url.$i?>"><?=$i?></a>
            <?php else:?>
                <a href="<?=$url.$i?>"><?=$i?></a>
            <?php endif;?>
        <?php endfor ?>
        <a href="<?=$url.$i?>">»</a>
    </div>
<?php endif ?>
