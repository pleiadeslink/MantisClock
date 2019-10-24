<?php

class IssueData {
    public $id;
    public $project_id;
    public $status;
    public $date_submitted = '';
    public $last_updated = '';
    public $summary = '';
}

class MantisClockPlugin extends MantisPlugin {

    function register() {
        $this->name = 'MantisClock';
        $this->description = 'This plugin aims to automatically reassign tickets once certain time has been reached since the ticket was created';
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

        $t_tickets_to_delete = create_ticket_list();
        foreach ($t_tickets_to_delete as $t_ticket) {
            echo bug_get($t_ticket -> id) -> p_handler_id;
            //bug_assign($t_ticket -> id, );
        }
    }

    // Returns array with all candidate tickets
    function create_ticket_list(){

        $t_issues_list = array();
        $t_reference_date_field = plugin_config_get('reference_date');
        
        # foreach project
        $t_projects = project_get_all_rows();
        foreach ($t_projects as $t_project_id => $t_project_data ) {
            $t_expiration_date = 1;
            $t_selected_issues = get_tickets($t_desired_statuses);
            foreach ($t_selected_issues as $t_issue) {
                if ($t_issue->$t_reference_date_field < $t_expiration_date ) {
                    $t_issue->expiration_date = $t_expiration_date;
                    $t_issues_list[] = $t_issue;
                }
            }
        }
        return $t_issues_list;
    }

    // Returns array 
    function get_tickets($p_desired_statuses) {

        global $g_cache_bug;

        // Filter
        $t_filter = filter_get_default();
        //$t_filter[FILTER_PROPERTY_STATUS] = $p_desired_statuses;
        //$t_filter['_view_type'] = 'advanced';
    
        // Get rows
        $t_page_number = -1;
        $t_per_page = 100;
        $t_bug_count = null;
        $t_page_count = null;
        $t_filter_result = array();
        $rows = filter_get_bug_rows( $t_page_number, $t_per_page, $t_page_count, $t_bug_count, $t_filter);
        for ($t_page = 1; $t_page <= $t_page_count; ++$t_page){
            // nuke the bug cache, otherwise we hit memory limit on large projects
            $g_cache_bug = null;
            $rows = filter_get_bug_rows( $t_page, $t_per_page, $t_page_count, $t_bug_count, $t_filter);
            foreach ($rows as $t_bug) {
                $t_new_data = new IssueData();
                $t_new_data->id = $t_bug->id;
                $t_new_data->project_id = $t_bug->project_id;
                $t_new_data->status = $t_bug->status;
                $t_new_data->date_submitted = $t_bug->date_submitted;
                $t_filter_result[] = $t_new_data;
            }
        }
    
        if($t_filter_result === false ) {
            echo "<p>EL FILTRO HA FALLADO<p>";
        }
    
        return $t_filter_result;
    }
}

?>