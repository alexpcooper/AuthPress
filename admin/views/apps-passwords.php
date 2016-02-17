<?php
$passwords = wpga_get_app_passwords();
$log       = wpga_get_app_passwords_log();
$alt       = 'class="alternate"';
?>
<div class="wrap">  
	<div class="icon32" id="icon-options-general"></div>  
	<h2><?php esc_html_e( 'Authenticator Applications Passwords', 'wpga' ); ?></h2>
	<p><?php esc_html_e( 'Apps passwords allow you to grant access to your WordPress administrative functions to applications that can\'t provide a one time password. This is useful if you use the WordPress mobile app for instance.', 'wpga' ); ?></p>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<table id="wpga-passwords-list" class="widefat">
							<thead>
								<tr>
									<th class="row-title"><?php esc_html_e( 'Description', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'Use Count', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'Last Used', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'IP', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'Actions', 'wpga' ); ?></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="row-title"><?php esc_html_e( 'Description', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'Use Count', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'Last Used', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'IP', 'wpga' ); ?></th>
									<th><?php esc_html_e( 'Actions', 'wpga' ); ?></th>
								</tr>
							</tfoot>
							<tbody>
								<?php if ( empty( $passwords ) ): ?>
									<tr id="wpas-no-app-password">
										<td colspan="4"><em><?php esc_html_e( 'No application password created yet.', 'wpga' ); ?></em></td>
									</tr>
								<?php else:
									foreach ( $passwords as $key => $password ):
										$alt       = '' === $alt ? 'class="alternate"' : '';
										$last      = wpga_get_last_access( $key );
										$last_date = false !== $last ? date( get_option( 'date_format' ), $last['last_used'] ) . ' ' . date( get_option( 'time_format' ), $last['last_used'] ) : __( 'Never', 'wpga' );
										$last_ip   = false !== $last ? $last['ip'] : '-';
										?>
										<tr <?php echo $alt; ?>>
											<td class="row-title"><?php echo esc_html( $password['description'] ); ?></td>
											<td><?php echo intval( $password['count'] ); ?></td>
											<td><?php echo esc_html( $last_date ); ?></td>
											<td><?php echo esc_html( $last_ip ); ?></td>
											<td><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'wpga_apps_passwords', 'action' => 'delete', 'key' => $key, 'wpga_nonce' => wp_create_nonce( 'wpga_action' ) ), admin_url( 'users.php' ) ) ); ?>"><?php esc_html_e( 'Delete', 'wpga' ); ?></a></td>
										</tr>
									<?php endforeach;
								endif; ?>
								<tr id="wpas-extra-row" style="display:none;">
									<th id="wpas-extra-row-description" class="row-title"></th>
									<th></th>
									<th><?php esc_html_e( 'Never', 'wpga' ); ?></th>
									<th>-</th>
									<th></th>
								</tr>
							</tbody>
						</table>
					</div> <!-- .postbox -->
				</div> <!-- .meta-box-sortables .ui-sortable -->

				<h3><?php esc_html_e( 'Add New', 'wpga' ); ?></h3>
				<p id="wpga-app-pwd-description"><?php esc_html_e( 'Apps passwords are automatically generated but you will need to provide a description for each password in order to easily identify it. Once an app password is generated you need to use it right away. For security reasons it will not be stored in plain text in the database, thus you will not be able to see it again.', 'wpga' ); ?></p>
				
				<table id="wpga-new-app-pwd" class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'wpga' ); ?></th>
							<td>
								<input type="text" id="app_pwd" name="wpga_app_password_desc" value="" class="regular-text" placeholder="<?php esc_attr_e( 'Add a description for this password', 'wpga' ); ?>" required />
								<a href="#" id="wpas-generate-app-pwd" class="button-secondary wpas-generate-app-pwd"><?php esc_html_e( 'Generate', 'wpga' ); ?></a>
							</td>
						</tr>
					</tbody>
				</table>

				<div id="wpga-app-pwd-container" style="text-align: center; display: none;">
					<p><?php esc_html_e( 'Your new password is:', 'wpga' ); ?></p>
					<div id="wpga-app-pwd" style="font-size:18px; font-weight: bold;"></div>
					<p><?php esc_html_e( 'Please use this password right now. You will NOT be able to see it again... ever!', 'wpga' ); ?></p>
				</div>
			</div> <!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">
					<div class="postbox">
						<h3><span><?php esc_html_e( 'When to use app passwords?', 'wpga' ); ?></span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'Whenever an application or a service asks for your password, you\'re better off creating a new app password. You can delete app passwords anytime.', 'wpga' ); ?></p>
							<p><?php echo wp_kses( __( '<strong>WARNING:</strong> app passwords will bypass the one time password. Don\'t abuse them.', 'wpga' ), array( 'strong' => array() ) ); ?></p>
						</div>
					</div> <!-- .postbox -->

					<div class="postbox">
						<h3><span><?php esc_html_e( 'Reset Apps Passwords', 'wpga' ); ?></span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'If you don\'t need your app passwords or you think they have been compromised you can reset all application passwords at once.', 'wpga' ); ?></p>
							<p style="text-align: center;"><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'wpga_apps_passwords', 'action' => 'delete_all', 'wpga_nonce' => wp_create_nonce( 'wpga_action' ) ), admin_url( 'users.php' ) ) ); ?>" class="button-primary"><?php esc_html_e( 'Reset Passwords', 'wpga' ); ?></a></p>
						</div>

					</div> <!-- .postbox -->
				</div> <!-- .meta-box-sortables -->
			</div> <!-- #postbox-container-1 .postbox-container -->

		</div>
		<br class="clear">
	</div>

	<h3><?php esc_html_e( 'Access Log', 'wpga' ); ?></h3>
	<p><?php printf( esc_html__( 'The access log will display the last %s access using one of your application passwords.', 'wpga' ), apply_filters( 'wpga_apps_passwords_log_max', 50 ) ); ?></p>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th class="row-title"><?php esc_html_e( 'Password Used', 'wpga' ); ?></th>
				<th><?php esc_html_e( 'Last Used', 'wpga' ); ?></th>
				<th><?php esc_html_e( 'IP', 'wpga' ); ?></th>
				<th><?php esc_html_e( 'User Agent', 'wpga' ); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th class="row-title"><?php esc_html_e( 'Password Used', 'wpga' ); ?></th>
				<th><?php esc_html_e( 'Last Used', 'wpga' ); ?></th>
				<th><?php esc_html_e( 'IP', 'wpga' ); ?></th>
				<th><?php esc_html_e( 'User Agent', 'wpga' ); ?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php if ( empty( $log ) ): ?>
				<tr>
					<td colsan="4"><em><?php esc_html_e( 'There are no entries yet.', 'wpga' ); ?></em></td>
				</tr>
			<?php else:
				foreach ( $log as $key => $entry ):

					$at_risk = false;
					$alt     = '' === $alt ? 'class="alternate"' : '';

					if ( array_key_exists( $entry['key'], $passwords ) ) {
						$app = $passwords[$entry['key']]['description'];
					} else {
						$app     = sprintf( __( 'Revoked key (#%s)', 'wpga' ), $entry['key'] );
						$alt     = 'class="form-invalid"';
						$at_risk = true;
					}
					?>
					<tr <?php echo $alt; ?>>
						<td class="row-title">
							<?php echo esc_html( $app ); ?>
							<?php if ( $at_risk ): ?>
							<small><a href="#" title="<?php printf( esc_attr__( 'If you have deleted the key #%s before the date of this log entry it means your account might be at risk.', 'wpga' ), $entry['key'] ); ?>" class="wpgahelp" tabindex="-1">[?]</a></small>
						<?php endif; ?>
						</td>
						<td>
							<?php echo esc_html( date( get_option( 'date_format' ), $entry['last_used'] ) ); ?>
							<?php echo esc_html( date( get_option( 'time_format' ), $entry['last_used'] ) ); ?>
						</td>
						<td><?php echo esc_html( $entry['ip'] ); ?></td>
						<td><?php echo esc_html( $entry['user_agent'] ); ?></td>
					</tr>
				<?php endforeach;
			endif; ?>
		</tbody>
	</table>
	<p><?php esc_html_e( 'You can clear the access log completely if needed', 'wpga' ); ?> <a href="<?php echo esc_url( add_query_arg( array( 'page' => 'wpga_apps_passwords', 'action' => 'clear_log', 'wpga_nonce' => wp_create_nonce( 'wpga_action' ) ), admin_url( 'users.php' ) ) ); ?>" class="button-secondary"><?php esc_html_e( 'Clear', 'wpga' ); ?></a></p>
</div>