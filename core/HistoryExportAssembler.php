<?php
declare(strict_types=1);

namespace app\core;

use app\models\History;
use Yii;

class HistoryExportAssembler
{
    /** @var HistoryBodyGetter */
    private $bodyGetter;

    public function __construct(
        HistoryBodyGetter $bodyGetter
    ) {
        $this->bodyGetter = $bodyGetter;
    }

    public function assemble(History $history): HistoryExportDto
    {
        $dto = new HistoryExportDto();
        $dto->insertTimestamp = $history->ins_ts;
        $dto->userName = isset($history->user) ? $history->user->username : Yii::t('app', 'System');
        $dto->type = $history->object;
        $dto->eventText = $history->eventText;
        $dto->body = ($this->bodyGetter)($history);

        return $dto;
    }
}