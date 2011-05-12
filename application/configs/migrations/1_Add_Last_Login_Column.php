<?php


class Add_Last_Login_Column extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('user', 'last_login', 'timestamp');
    }

    public function down()
    {
        $this->removeColumn('user', 'last_login');
    }
}