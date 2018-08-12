<?php
namespace controllers;
use \Exception;
use \mysqli;
use gchumillas\http\HttpController;

class LoginController extends HttpController
{
    private $_conn;
    private $_token = "";

    public function __construct()
    {
        $this->_conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        $this->on("POST", [$this, "post"]);
    }

    public function getDocument()
    {
        return json_encode(["token" => $this->_token]);
    }

    public function post()
    {
        $username = $this->getParam("username", ["required" => true]);
        $password = $this->getParam("password", ["required" => true]);

        $stmt = $this->_conn->prepare("
        select
            token
        from user
        where username = ?
        and password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->bind_result($this->_token);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();

        if (strlen($this->_token) == 0) {
            throw new Exception("User not found");
        }
    }
}
