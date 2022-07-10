<?php
declare(strict_types=1);

namespace app\core;

use app\models\User;

class HistoryCommonDto
{
    /** @var User|null */
    public $user;

    /** @var string */
    public $body;

    /** @var string */
    public $bodyDatetime;

    /** @var string */
    public $content;

    /** @var string|null */
    public $footer;

    /** @var string */
    public $footerDatetime;

    /** @var string */
    public $iconClass;

    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'body' => $this->body,
            'bodyDatetime' => $this->bodyDatetime,
            'content' => $this->content,
            'footer' => $this->footer,
            'footerDatetime' => $this->footerDatetime,
            'iconClass' => $this->iconClass,
        ];
    }
}