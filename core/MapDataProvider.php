<?php
declare(strict_types=1);

namespace app\core;

use yii\base\BaseObject;
use yii\data\BaseDataProvider;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;

class MapDataProvider extends BaseObject implements DataProviderInterface
{
    /** @var BaseDataProvider */
    private $next;

    /** @var callable */
    private $callback;

    /** @var array */
    private $callbackParams;

    public function __construct(
        BaseDataProvider $next,
        callable $callback,
        array $callbackParams = []
    ) {
        $this->next = $next;
        $this->callback = $callback;
        $this->callbackParams = $callbackParams;

        parent::__construct();
    }

    public function prepare($forcePrepare = false): void
    {
        $this->next->prepare($forcePrepare);
    }

    public function getCount(): int
    {
        return $this->next->getCount();
    }

    public function getTotalCount(): int
    {
        return $this->next->getTotalCount();
    }

    public function getModels(): array
    {
        return array_map(function ($model) {
            return \call_user_func_array($this->callback, ArrayHelper::merge([$model], $this->callbackParams));
        }, $this->next->getModels());
    }

    public function getKeys(): array
    {
        return $this->next->getKeys();
    }

    public function getSort()
    {
        return $this->next->getSort();
    }

    public function getPagination()
    {
        return $this->next->getPagination();
    }

    public function setPagination($value): void
    {
        $this->next->setPagination($value);
    }

    public function setTotalCount($value): void
    {
        $this->next->setTotalCount($value);
    }

    public function refresh(): void
    {
        $this->next->refresh();
    }
}