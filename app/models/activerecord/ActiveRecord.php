<?php

namespace Mervy\ActiveRecord\database\activerecord;

use ReflectionClass;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

abstract class ActiveRecord implements ActiveRecordInterface
{

    protected $table = null;
    protected $attributes = [];

    public function __construct()
    {
        /**
         * Se não for definido ´table´ no model
         * pega o nome da classe como nome da tabela
         * Note que ficará no singular, mas as tabelas
         * estarão no plural, daí o segundo if para corrigir
         */
        if (!$this->table) {
            $this->table = strtolower((new ReflectionClass($this))->getShortName());
            //Verifico a última letra do nome da classe
            $ocurrency = str_ends_with($this->table, 'y');
            //Acrescento 'ies' se final for y e 's' para outra letra qualquer
            match ($ocurrency) {
                true => $this->table = rtrim($this->table, 'y') . 'ies',
                default => $this->table = $this->table . 's'
            };
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Se uma tabela crescer, usando o __set ela
     * pode ter qualquer tamanho 
     */
    public function __set($attribute, $value)
    {
        /**
         * $attribute = firstName, $value = Mary
         * $user->firstName = "Mary";  
         */
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
