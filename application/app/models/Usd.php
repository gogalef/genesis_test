<?php

use Phalcon\Mvc\Model;

class Usd extends Model
{
    public function rate()
    {
        $raw_result = $this->getDI()->get('db')->query('SELECT usd.sp_select_current_value(\'' . date("Y-m-d") . '\'  )');
        $result = json_decode($raw_result->fetchAll()[0][0],true);
        if(!isset($result['error']))
        {
            $result = $result['data'][0];
        }
        else
        {
            $result = 'error_database';
        }
        return $result;
    }

    public function addUser( $email )
    {
        $success =json_decode(
            $this->getDI()->get('db')->query(
                'SELECT usd.sp_add_user_email(\'' . json_encode(['email' => $email],256) . '\')')->fetchArray()[0],
            true
        );
        if(!isset($success['error']))
        {
            $success = $success['data'][0];
        }
        else
        {
            $success = 'error_database';
        }

        return $success;
    }

}
