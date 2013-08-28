<?php
/* Class Request 
   request.class.php
*/
class Request {

    public function getPost($param, $default = '')
    {
        if( !isset($_POST[$param]) || empty($_POST[$param]) )
        {
            return $default;
        }
        
        return $_POST[$param];
    }

    // If param is set both in $_GET and $_POST, $_GET is return.
    public function getParam($param, $default = '')
    {
        if( !isset($_GET[$param]) || empty($_GET[$param]) )
        {
            return $this->getPost($param, $default);
        }
        return $_GET[$param];
    }
}
?>