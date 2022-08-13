<?php if(count($errMsgs) !== 0): ?>
    <ul>
    <?php foreach($errMsgs as $error): ?>
        <li id="form_error"><?= $error; ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

