<?php
class Controller {
    var $rendered = false;

    function header() {
        include_once 'include/header.php';
    }
    function footer() {
        include_once 'include/footer.php';
    }
    function execute($action) {
        $method = 'action_' . $action;
        $this->$method();
        $this->render($action);
    }
    function render($action) {
        if (!$this->rendered) {
            $this->header();
            include "skins/$this->skin/$action.php";
            $this->footer();
            $this->rendered = true;
        }
    }
}
?>
