<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
/**
 * Usd check and subrscribe to updates controller
 */
class UsdApiController extends BasicApiController
{
    /**
     * Usd check
     */
    public function rateAction()
    {
        $db_result = ( new Usd )->rate();
        if( $db_result !== 'error_database' )
        {
           $this->response_data        = $db_result;
        }
        else
        {
            $this->response_data       = 'Invalid status value';
            $this->response_status     = 400;
        }
        return true;
    }

    public function subscribeAction()
    {
        $email = $this->request->getPost()['email'];
        if( preg_match( "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email ) )
        {
            $db_result = ( new Usd )->addUser($email);
            if( $db_result !== 'error_database' )
            {
                $this->response_data        = 'E-mail додано';
            }
            else
            {
                $this->response_data       = 'E-mail вже є в базі даних';
                $this->response_status     = 409;
            }
        }
        else
        {
            $this->response_data       = 'Invalid status value';
            $this->response_status     = 400;
        }
        return true;
    }
}
