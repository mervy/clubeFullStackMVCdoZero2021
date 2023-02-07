<?php

namespace Mervy\ActiveRecord\database\activerecord;

use Mervy\ActiveRecord\database\connection\Connection;
use Throwable;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

class Insert implements ActiveRecordExecuteInterface
{
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();

            $prepare = $connection->prepare($query);
            return $prepare->execute($activeRecordInterface->getAttributes());
           
        } catch (Throwable $th) {
            formatException($th);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        //INSERT INTO `_mvc2021`.authors (firstName, lastName, email, password, status) VALUES('', '', '', '', '0');
        $sql = "INSERT INTO {$activeRecordInterface->getTable()} (";
        $sql .= implode(', ', array_keys($activeRecordInterface->getAttributes())) . ') VALUES(';
        $sql .= ':' . implode(', :', array_keys($activeRecordInterface->getAttributes())) . ')';
        return $sql;

    }
}
