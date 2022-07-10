<?php
declare(strict_types=1);

namespace app\core;

use app\models\Customer;
use app\models\History;
use Yii;
use yii\helpers\Html;

class HistoryCustomerAssembler
{
    public function assemble(History $history): HistoryCustomerDto
    {
        $dto = new HistoryCustomerDto();
        $dto->eventText = $history->eventText;
        $dto->oldValue = $this->getOldValue($history);
        $dto->newValue = $this->getNewValue($history);
        $dto->datetime = $history->ins_ts;
        $dto->user = $history->user;
        $dto->content = null;

        return $dto;
    }

    /**
     * @param History $history
     * @return string|null
     */
    private function getOldValue(History $history)
    {
        switch ($history->event) {
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
                return Customer::getTypeTextByType($history->getDetailOldValue('type'));
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                return Customer::getQualityTextByQuality($history->getDetailOldValue('quality'));
            default:
                return null;
        }
    }

    /**
     * @param History $history
     * @return string|null
     */
    private function getNewValue(History $history)
    {
        switch ($history->event) {
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
                return Customer::getTypeTextByType($history->getDetailNewValue('type'));
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                return Customer::getQualityTextByQuality($history->getDetailNewValue('quality'));
            default:
                return null;
        }
    }
}