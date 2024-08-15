<?php
class API {
    var $apiName = "";
    var $code = 0;
    var $message = "";
    var $entity = "";

    public function getApiName()
    {
        return $this->apiName;
    }

    function setApiName($apiName)
    {
        $this->apiName = $apiName;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}
?>