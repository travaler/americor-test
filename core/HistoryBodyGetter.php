<?php
declare(strict_types=1);

namespace app\core;

use app\models\History;

class HistoryBodyGetter
{
    public function __invoke(History $history): string
    {
        switch ($history->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
                $task = $history->task;
                return "$history->eventText: " . ($task->title ?? '');
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
                return $history->sms->message ?: '';
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                $call = $history->call;
                return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ? " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');
            default:
                return $history->eventText;
        }
    }
}