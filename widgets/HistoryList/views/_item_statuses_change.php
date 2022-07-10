<?php

use app\models\History;
use app\models\User;

/* @var $eventText History */
/* @var $oldValue string */
/* @var $newValue string */
/** @var $datetime string */
/** @var $user User */
/* @var $content string */
?>

    <div class="bg-success ">
        <?php echo "$eventText " .
            "<span class='badge badge-pill badge-warning'>" . ($oldValue ?? "<i>not set</i>") . "</span>" .
            " &#8594; " .
            "<span class='badge badge-pill badge-success'>" . ($newValue ?? "<i>not set</i>") . "</span>";
        ?>

        <span><?= \app\widgets\DateTime\DateTime::widget(['dateTime' => $datetime]) ?></span>
    </div>

<?php if (isset($user)): ?>
    <div class="bg-info"><?= $user->username; ?></div>
<?php endif; ?>

<?php if (isset($content) && $content): ?>
    <div class="bg-info">
        <?php echo $content ?>
    </div>
<?php endif; ?>