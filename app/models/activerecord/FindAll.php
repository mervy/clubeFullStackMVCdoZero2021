<?php

namespace Naplanum\MVC\models\activerecord;

use Exception;
use Throwable;
use Naplanum\MVC\models\connection\Connection;
use Naplanum\MVC\interfaces\ActiveRecordInterface;
use Naplanum\MVC\interfaces\ActiveRecordExecuteInterface;

class FindAll implements ActiveRecordExecuteInterface
{
    public function __construct(
        private array $where = [],
        private string|int $limit = '',
        private string|int $offset = '',
        private string $fields = '*',
    ) {
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();

            $prepare = $connection->prepare($query);
            $prepare->execute($this->where);

            return $prepare->fetchAll();
        } catch (Throwable $th) {
            formatException($th);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface){
        if (count($this->where) > 1) {
            throw new Exception("No WHERE só pode passar um índice!");
        }

        $where = array_keys($this->where);
        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()}";
        
    }
}
