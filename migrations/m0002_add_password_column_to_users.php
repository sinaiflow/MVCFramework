<?php

class m0002_add_password_column_to_users
{

    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN `password` VARCHAR(30) NOT NULL;");
    }
    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users DROP COLUMN `password`;");
    }

}