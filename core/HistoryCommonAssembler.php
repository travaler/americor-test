<?php
declare(strict_types=1);

namespace app\core;

use app\models\Call;
use app\models\History;
use app\models\Sms;
use Yii;
use yii\helpers\Html;

class HistoryCommonAssembler
{
    /** @var HistoryBodyGetter */
    private $bodyGetter;

    public function __construct(
        HistoryBodyGetter $bodyGetter
    ) {
        $this->bodyGetter = $bodyGetter;
    }

    public function assemble(History $history): HistoryCommonDto
    {
        $dto = new HistoryCommonDto();
        $dto->user = $history->user;
        $dto->body = ($this->bodyGetter)($history);
        $dto->bodyDatetime = $this->getBodyDatetime($history);
        $dto->content = $this->getContent($history);
        $dto->footer = $this->getFooter($history);
        $dto->footerDatetime = $this->getFooterDatetime($history);
        $dto->iconClass = $this->getIconClass($history);

        return $dto;
    }

    /**
     * @param History $history
     * @return string|null
     */
    private function getBodyDatetime(History $history)
    {
        switch ($history->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                return null;
            default:
                return $history->ins_ts;
        }
    }

    private function getContent(History $history): string
    {
        switch ($history->event) {
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                $call = $history->call;
                return $call->comment ?? '';
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
            default:
                return '';
        }
    }

    /**
     * @param History $history
     * @return string|null
     */
    private function getFooter(History $history)
    {
        switch ($history->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
                $task = $history->task;
                return isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : '';
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
                return $history->sms->direction == Sms::DIRECTION_INCOMING ?
                    Yii::t('app', 'Incoming message from {number}', [
                        'number' => $model->sms->phone_from ?? ''
                    ]) : Yii::t('app', 'Sent message to {number}', [
                        'number' => $model->sms->phone_to ?? ''
                    ]);
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
                $fax = $history->fax;
                return Yii::t('app', '{type} was sent to {group}', [
                    'type' => $fax ? $fax->getTypeText() : 'Fax',
                    'group' => isset($fax->creditorGroup) ? Html::a($fax->creditorGroup->name,['creditors/groups'], ['data-pjax' => 0]) : ''
                ]);
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                $call = $history->call;
                return isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null;
            default:
                return null;
        }
    }

    /**
     * @param History $history
     * @return string|null
     */
    private function getFooterDatetime(History $history)
    {
        switch ($history->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                return $history->ins_ts;
            default:
                return null;
        }
    }

    /**
     * @param History $history
     * @return string
     */
    private function getIconClass(History $history): string
    {
        switch ($history->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
                return 'fa-check-square bg-yellow';
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
                return 'icon-sms bg-dark-blue';
            case History::EVENT_OUTGOING_FAX:
            case History::EVENT_INCOMING_FAX:
                return 'fa-fax bg-green';
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                $call = $history->call;
                $answered = $call && $call->status == Call::STATUS_ANSWERED;
                return $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red';
            default:
                return 'fa-gear bg-purple-light';
        }
    }
}