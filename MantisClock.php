<?php

class MantisClockPlugin extends MantisPlugin {

    function register() {
        $this->name = 'MantisClock';
        $this->description = 'This plugin aims to automatically reassign tickets once certain time has passed';
        $this->page = 'https://github.com/FractalMonkey/MantisClock';
        $this->version = '0.1';
        $this->requires = array(
            "MantisCore" => "2.0.0",
        );
        $this->author = 'José Maestre';
        $this->contact = 'nah@address.com';
        $this->url = 'https://github.com/FractalMonkey';
    }

    function hooks() {
        return array(
            "EVENT_LAYOUT_PAGE_FOOTER" => 'updateTickets',
        );
    }

    function updateTickets() {
        
    }
}

?>