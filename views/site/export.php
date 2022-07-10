<?php

/**
 * @var $this yii\web\View
 * @var $model \app\models\History
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $exportType string
 */

use app\models\History;
use app\widgets\Export\Export;

$filename = 'history';
$filename .= '-' . time();

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>

<?= Export::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'insertTimestamp',
            'label' => Yii::t('app', 'Date'),
            'format' => 'datetime'
        ],
        [
            'label' => Yii::t('app', 'User'),
            'attribute' => 'userName',
        ],
        [
            'label' => Yii::t('app', 'Type'),
            'attribute' => 'type',
        ],
        [
            'label' => Yii::t('app', 'Event'),
            'attribute' => 'eventText',
        ],
        [
            'label' => Yii::t('app', 'Message'),
            'attribute' => 'body',
        ]
    ],
    'exportType' => $exportType,
    'batchSize' => 2000,
    'filename' => $filename
]);