<?php

use app\core\HistoryCommonDto;
use app\core\HistoryCustomerDto;

/** @var $model HistoryCommonDto|HistoryCustomerDto */

switch (true) {
    case $model instanceof HistoryCustomerDto:
        echo $this->render('_item_statuses_change', $model->toArray());
        break;
    default:
        echo $this->render('_item_common', $model->toArray());
        break;
}
