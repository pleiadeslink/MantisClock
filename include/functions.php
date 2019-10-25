<?php

class IssueData {
    public $id;
    public $project_id;
    public $status;
    public $date_submitted = "";
    public $last_updated = "";
    public $summary = "";
}

function update_tickets() {
    $t_ticket_list = array();
    $t_selected_tickets = get_tickets();
    foreach($t_selected_tickets as $t_ticket) {
        echo $t_ticket -> id;
    }
}

function get_tickets() {
    global $g_cache_bug;
    $t_filter = filter_get_default();
    $t_page_number = -1;
    $t_per_page = 100;
    $t_bug_count = null;
    $t_page_count = null;
    $rows = filter_get_bug_rows( $t_page_number, $t_per_page, $t_page_count, $t_bug_count, $t_filter);
    $t_filter_result = array(); // Results array
    for($t_page = 1; $t_page <= $t_page_count; ++$t_page){
        $g_cache_bug = null; // Nuke the bug cache, otherwise we hit memory limit on large projects
        $rows = filter_get_bug_rows( $t_page, $t_per_page, $t_page_count, $t_bug_count, $t_filter);
        foreach($rows as $t_bug) {
            $t_new_data = new IssueData();
            $t_new_data -> id = $t_bug -> id;
            $t_new_data -> project_id = $t_bug -> project_id;
            $t_new_data -> status = $t_bug -> status;
            $t_new_data -> date_submitted = $t_bug -> date_submitted;
            array_push($t_filter_result, $t_new_data);
        }
    }

    if($t_filter_result === false ) {
        echo "<p>EL FILTRO HA FALLADO<p>";
    }

    return $t_filter_result;
}