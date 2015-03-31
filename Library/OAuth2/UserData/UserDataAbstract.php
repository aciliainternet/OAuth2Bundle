<?php
namespace Acilia\Bundle\OAuth2Bundle\Library\OAuth2\UserData;

abstract class UserDataAbstract
{
    protected $data;

    abstract public function getName();

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}
