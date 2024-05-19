<?php

use Phalcon\Mvc\Model;

class Mails extends Model
{
    public function test()
    {
        $raw_result = $this->getDI()->get('db')->query('INSERT INTO usd.test ( test) VALUES( \'t\')');

        return true;
    }
    public function getAllEmails()
    {

        $raw_result =  $this->getDI()->get('db')->query('SELECT usd.sp_select_emails()');
        $result = json_decode($raw_result->fetchAll()[0][0],true);
        return $result;
    }

}
