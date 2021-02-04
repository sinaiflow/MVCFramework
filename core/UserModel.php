<?php


namespace app\core;


use app\core\db\DatabaseModel;

abstract class UserModel extends DatabaseModel
{
    abstract public function getDisplayName(): string;
}