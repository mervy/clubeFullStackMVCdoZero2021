<?php

namespace Mervy\ActiveRecord\database\interfaces;

interface ActiveRecordExecuteInterface
{
    public function execute(ActiveRecordInterface $activeRecordInterface);
}