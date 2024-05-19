<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class BasicApiController extends Controller
{
    protected $response_data        = null;
    protected $response_status      = 200;
    public function beforeExecuteRoute()
    {
        $this->view->disable();
        return true;
    }
    // Implement common logic
    public function afterExecuteRoute()
    {
        $this->response->setContentType('application/json', 'UTF-8');

        $this->response->setStatusCode( $this->response_status );

        $this->response->setContent( json_encode( $this->response_data, JSON_UNESCAPED_UNICODE ) );
        echo($this->response->getContent());

        return $this->response;
    }
}
