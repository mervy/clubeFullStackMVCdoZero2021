<?php

namespace Naplanum\MVC\models\activerecord;

use ReflectionClass;
use Throwable;
use Naplanum\MVC\models\connection\Connection;
use Naplanum\MVC\interfaces\ActiveRecordInterface;
use Naplanum\MVC\interfaces\ActiveRecordExecuteInterface;

abstract class ActiveRecord implements ActiveRecordInterface
{
    protected $table = null;

    protected $attributes = [];

    public function _construct()
    {
        if (!$this->table) {
            $this->table = strtolower((new ReflectionClass($this))->getShortName());
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getAtributes()
    {
        return $this->attributes;
    }

    public function __set($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    public function __get($attribute)
    {
        return $this->attributes[$attribute];
    }

    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface)
    {
        return $activeRecordExecuteInterface->execute($this);
    }
}
