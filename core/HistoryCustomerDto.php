<?php
declare(strict_types=1);

namespace app\core;

use app\models\User;

class HistoryCustomerDto
{
    /** @var string */
    public $eventText;

    /** @var string|null */
    public $oldValue;

    /** @var string|null */
    public $newValue;

    /** @var string */
    public $datetime;

    /** @var User|null */
    public $user;

    /** @var string|null */
    public $content;

    public function toArray(): array
    {
        return [
            'eventText' => $this->eventText,
            'oldValue' => $this->oldValue,
            'newValue' => $this->newValue,
            'datetime' => $this->datetime,
            'user' => $this->user,
            'content' => $this->content,
        ];
    }
}