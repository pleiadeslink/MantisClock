<?php

// Días habiles?

class ticketData {
    public $id;
    public $status;
    public $date_submitted = "";
    public $last_updated = "";
    public $summary = "";
}

function update_tickets() {
    $t_ticket_list = array();
    $t_selected_tickets = get_tickets();
    foreach($t_selected_tickets as $t_ticket) {
        // If the ticket has status 10 (new) and is older than 3 days
        $t_ticket_counter = 0;
        if($t_ticket -> status == 10 and get_days_from_date($t_ticket -> date_submitted) > 0) {
            //echo ;
            ++$t_ticket_counter;
        }
    }
    echo '<p style="color:#008000; font-weight:bold">OK</p>';
    if($t_ticket_counter == 1) {
        echo '1 solicitud aceptada automáticamente.<br><br>';
    } else {
        echo $t_ticket_counter . ' solicitudes aceptadas automáticamente.<br><br>';
    }
}

function get_tickets() {
    global $g_cache_bug;
    $t_filter = filter_get_default();
    $t_page_number = -1;
    $t_per_page = 100;
    $t_bug_count = null;
    $t_page_count = null;
    $rows = filter_get_bug_rows( $t_page_number, $t_per_page, $t_page_count, $t_bug_count, $t_filter); // ?????
    $t_filter_result = array();
    for($t_page = 1; $t_page <= $t_page_count; ++$t_page) {
        $g_cache_bug = null; // Nuke the bug cache, otherwise we can hit memory limit on large projects
        $rows = filter_get_bug_rows( $t_page, $t_per_page, $t_page_count, $t_bug_count, $t_filter);
        foreach($rows as $t_bug) {
            $t_new_data = new ticketData();
            $t_new_data -> id = $t_bug -> id;
            $t_new_data -> status = $t_bug -> status;
            $t_new_data -> date_submitted = $t_bug -> date_submitted;
            $t_new_data -> last_updated = $t_bug -> last_updated;
            array_push($t_filter_result, $t_new_data);
        }
    }
    if($t_filter_result === false ) {
        echo "<p>EL FILTRO HA FALLADO.<p>";
    }
    return $t_filter_result;
}

function get_days_from_date($date) {
    return ceil(abs(time() - $date) / 86400) - 1;
}