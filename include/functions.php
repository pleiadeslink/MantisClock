<?php

// Días habiles?

class ticketData {
    public $id;
    public $status;
    public $resolution;
    public $date_submitted = "";
    public $last_updated = "";
    public $summary = "";
}

function update_tickets() {
    $t_ticket_list = get_tickets();
    $t_result_list = array();
    foreach($t_ticket_list as $t_ticket) {
        if(($t_ticket -> status == NEW_ and get_days_from_date($t_ticket -> date_submitted) > 0)
           or ($t_ticket -> status > NEW_ and $t_ticket -> resolution == OPEN and get_days_from_date($t_ticket -> last_updated) > 0)) {
            bug_resolve($t_ticket -> id, 20); // 20:aceptada
            bug_assign($t_ticket -> id, user_get_id_by_name('sasis'));
            array_push($t_result_list, $t_ticket -> id);
        }
    }
    echo '<p style="color:#008000; font-weight:bold">OK</p>';
    if(sizeof($t_result_list) == 0) {
        echo 'No hay solicitudes fuera de plazo.<br>';
    } else {
        if(sizeof($t_result_list) == 1) {
            echo '1 solicitud aceptada automáticamente:<br>';
        } else {
            echo sizeof($t_result_list) . ' solicitudes aceptadas automáticamente:<br>';
        }
        foreach($t_result_list as $t_ticket) {
            echo '<a href="view.php?id=' . $t_ticket . '" target="_blank">' . $t_ticket . ': ' . bug_get_field($t_ticket, 'summary') . '</a><br>';
        }
    }
    echo '<br>';
}

function get_tickets() {
    global $g_cache_bug;
    $t_filter = filter_get_default();
    $t_page_number = -1;
    $t_per_page = 100;
    $t_bug_count = null;
    $t_page_count = null;
    $rows = filter_get_bug_rows($t_page_number, $t_per_page, $t_page_count, $t_bug_count, $t_filter); // ?????
    $t_filter_result = array();
    for($t_page = 1; $t_page <= $t_page_count; ++$t_page) {
        $g_cache_bug = null; // Nuke the bug cache, otherwise we can hit memory limit on large projects
        $rows = filter_get_bug_rows($t_page, $t_per_page, $t_page_count, $t_bug_count, $t_filter);
        foreach($rows as $t_bug) {
            $t_new_data = new ticketData();
            $t_new_data -> id = $t_bug -> id;
            $t_new_data -> status = $t_bug -> status;
            $t_new_data -> resolution = $t_bug -> resolution;
            $t_new_data -> date_submitted = $t_bug -> date_submitted;
            $t_new_data -> last_updated = $t_bug -> last_updated;
            array_push($t_filter_result, $t_new_data);
        }
    }
    /*if($t_filter_result === false ) {
        echo "<p>EL FILTRO HA FALLADO.<p>";
    }*/
    return $t_filter_result;
}

function get_days_from_date($date) {
    return ceil(abs(time() - $date) / 86400) - 1;
}