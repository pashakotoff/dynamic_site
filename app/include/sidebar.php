<?php include SITE_ROOT."/app/controllers/topics.php";?>
<div class="sidebar col-md-3 col-12">
    <div class="section search">
        <h3>Поиск</h3>
        <form action="search.php" method="post">
            <input type="text" name="search_term" class="text-input" placeholder="поиск">

        </form>
    </div>
    <div class="section topics">
        <h3>Категории</h3>
        <ul>
            <?php foreach($topicsArr as $val):?>
                <li><a href="category.php?topic_id=<?= $val['id'];?>"><?= $val['name'];?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>