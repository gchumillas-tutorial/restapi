<?php
namespace controllers;
use \Exception;
use \mysqli;
use gchumillas\http\HttpController;

class ItemListController extends HttpController
{
    private $_conn;
    private $_items = [];

    public function __construct()
    {
        $this->_conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        $this->onOpen([$this, "open"]);
    }

    public function getDocument()
    {
        return json_encode($this->_items);
    }

    public function open()
    {
        $token = $this->getParam("token", ["required" => true]);

        // is valid token?
        $id = "";
        $stmt = $this->_conn->prepare("
        select
            id
        from user
        where token = ?");
        $stmt->bind_param("s", $token);
        $stmt->bind_result($id);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();

        if (strlen($id) == 0) {
            throw new Exception("Invalid credentials");
        }

        // fetches items
        $this->_items = [];
        $result = $this->_conn->query("
        select
            id,
            title,
            description
        from item
        order by id desc");
        while ($row = $result->fetch_assoc()) {
            array_push($this->_items, $row);
        }
        $result->free();
    }
}
