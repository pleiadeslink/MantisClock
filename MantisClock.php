<?php

require('include/functions.php');

class MantisClockPlugin extends MantisPlugin {

    function register() {
        $this->name = "MantisClock";
        $this->description = "This plugin aims to automatically reassign tickets once certain time has been reached since the ticket was created";
        $this->page = "https://github.com/fractalmonkey/mantisclock";
        $this->version = "0.4";
        $this->requires = array(
            "MantisCore" => "2.0.0",
        );
        $this->author = "José Maestre";
        $this->contact = "nah@address.com";
        $this->url = "https://github.com/fractalmonkey/mantisclock";
    }

    function events() {
        return array(
            "EVENT_MANTISCLOCK_RUN" => EVENT_TYPE_EXECUTE
        );
    }

    function hooks() {
        return array(
            "EVENT_MANTISCLOCK_RUN" => "run"
        );
    }

    function run() {
        update_tickets();
    }


}