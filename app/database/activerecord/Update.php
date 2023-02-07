<?php

namespace Mervy\ActiveRecord\database\activerecord;

use Exception;
use Throwable;
use Mervy\ActiveRecord\database\connection\Connection;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

class Update implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value)
    {
    }
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();

            $attributes = array_merge($activeRecordInterface->getAttributes(), [
                $this->field => $this->value
            ]);

            $prepare = $connection->prepare($query);
            $prepare->execute($attributes);
            return $prepare->rowCount();
        } catch (Throwable $th) {
            formatException($th);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        // UPDATE `_mvc2021`.authors SET id=0, firstName=:firstName, lastName='', password='', status='0' WHERE id= :id;

        //Se setar o id, dá o erro abaixo [$user->id = 1;]
        if (array_key_exists('id', $activeRecordInterface->getAttributes())) {
            throw new Exception('O campo id não pode ser passado para o update');
        }

        $sql = "UPDATE {$activeRecordInterface->getTable()} SET ";
        foreach ($activeRecordInterface->getAttributes() as $key => $value) {
            $sql .= "{$key}=:{$key}, ";
        }

        //Retira a última vírgula e espaço
        $sql = rtrim($sql, ', ');

        $sql .= " WHERE {$this->field}=:{$this->field}";

        return $sql;
    }
}
