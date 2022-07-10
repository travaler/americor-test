<?php
declare(strict_types=1);

namespace app\core;

use app\models\History;

class HistoryAssembler
{
    /** @var HistoryCommonAssembler */
    private $commonAssembler;

    /** @var HistoryCustomerAssembler */
    private $customerAssembler;

    /** @var HistoryExportAssembler */
    private $exportAssembler;

    public function __construct(
        HistoryCommonAssembler $commonAssembler,
        HistoryCustomerAssembler $customerAssembler,
        HistoryExportAssembler $exportAssembler
    )
    {
        $this->commonAssembler = $commonAssembler;
        $this->customerAssembler = $customerAssembler;
        $this->exportAssembler = $exportAssembler;
    }

    public function assemble(History $history, bool $forExport = false)
    {
        if ($forExport) {
            return $this->exportAssembler->assemble($history);
        }

        switch ($history->event) {
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                return $this->customerAssembler->assemble($history);
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
            default:
                return $this->commonAssembler->assemble($history);
        }
    }


}