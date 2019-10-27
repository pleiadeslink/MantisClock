<?php
require_once('core.php');
layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin();
print_manage_menu();
?>
<br />

<div class="col-md-12 col-xs-12">
	<div class="widget-box widget-color-blue2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">Actualización de solicitudes</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main no-padding">
				<div class="table-responsive">
					<div style="padding: 10px;">
						<?php
						echo '<p>Actualizando solicitudes fuera de plazo...</p>';
						event_signal("EVENT_MANTISCLOCK_RUN");
						?>
						<a class="btn btn-primary btn-white btn-round btn-sm" href="my_view_page.php">Continuar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
layout_page_end();