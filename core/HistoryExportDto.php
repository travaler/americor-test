<?php
declare(strict_types=1);

namespace app\core;

class HistoryExportDto
{
    /** @var string */
    public $insertTimestamp;

    /** @var string */
    public $userName;

    /** @var string */
    public $type;

    /** @var string */
    public $eventText;

    /** @var string */
    public $body;
}