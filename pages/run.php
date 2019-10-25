<?php

require_once('core.php');

echo '<p>Here is a link to <a href="', plugin_page( 'foo' ), '">page foo</a>.</p>';
event_signal("EVENT_MANTISCLOCK_RUN");

