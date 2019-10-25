<?php

require('include/functions.php');

class MantisClockPlugin extends MantisPlugin {

    function register() {
        $this->name = "MantisClock";
        $this->description = "This plugin aims to automatically reassign tickets once certain time has been reached since the ticket was created";
        $this->page = "https://github.com/FractalMonkey/MantisClock";
        $this->version = "0.1";
        $this->requires = array(
            "MantisCore" => "2.0.0",
        );
        $this->author = "José Maestre";
        $this->contact = "nah@address.com";
        $this->url = "https://github.com/FractalMonkey";
    }

    function events() {
        return array(
            "EVENT_MANTISCLOCK_RUN" => EVENT_TYPE_EXECUTE,
            "EVENT_MANTISCLOCK_" => EVENT_TYPE_EXECUTE
        );
    }

    function hooks() {
        return array(
            "EVENT_LAYOUT_PAGE_FOOTER" => "updateTickets",
            "EVENT_MANTISCLOCK_RUN" => "run",
            "EVENT_MANTISCLOCK_UPDATE" => "update_tickets"
        );
    }

    // Returns array 
    function run() {
        //update_tickets();
        update_tickets();
    }


}
?>