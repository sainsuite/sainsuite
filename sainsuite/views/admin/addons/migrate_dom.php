<div class="row">
<?php if (is_file($migrate_file)) : ?>
	<div id="migration-progress">
		<p><?php _e('Migration has started'); ?></p>
	</div>

    <script>
	$(document).ready(function(e) 
    {
		var Migration_Url = '<?php echo site_url(array( 'admin', 'addons', 'exec', $addon[ 'application' ][ 'namespace' ] )); ?>';
		var MigrationData =	<?php echo $migrate_data; ?>;
		var textDomain 	=	{
			doing: `<?php echo __( 'Doing' );?>`,
			anErrorOccured: `<?php echo __( 'An Error Occured' );?>`,
		}
		var Migration =	new function() {
			this.Do = function() {
				if( MigrationData.length > 0 )
				{
					$.ajax( Migration_Url + '/run/' + MigrationData[0], {
						dataType:"JSON",
						beforeSend: function(){
							$( '#migration-progress' ).append( '<p>' + '<?php _e('Migrating to');?> : ' + MigrationData[0] + '</p>' );
						},
						success: function( result ) {
							if( result.status === 'success' ) 
							{
								$( '#migration-progress p:last-child' ).append( ' &mdash; ' + '<?php _e('done.');?>' );
								if ( result.data ) {
									dynamic.run( result.data );
								} 
								else {
									MigrationData.shift();
									Migration.Do();
								}
							} 
							else {
								$( '#migration-progress' ).append( '<p>' + '<?php _e('An error occured :');?> ' + result.message + '</p>' );
							}
						},
					});
				} 
				else {
					$( '#migration-progress' ).append( '<p>' + '<?php _e('Migration done.');?>' + '</p>' );
					$( '#migration-progress' ).append( '<p><a class="btn btn-default" href="' + '<?php echo site_url(array( 'admin', 'addons?highlight=' . $addon[ 'application' ][ 'namespace' ] ));?>' + '">' + '<?php _e('Go back to addons');?>' + '</a></p>' );
				}
			}
		};
		var dynamic = new function() {
			this.run = function( data ) {
				if ( $( `.${data.class}` ).length === 0 ) {
					$( '#migration-progress' ).append( `<p class="${data.class}">&mdash; ${textDomain.doing} : ${data.title}` );
				} else {
					$( `.${data.class}` ).html( `&mdash; ${textDomain.doing} : ${data.title}` );
				}
				HttpRequest.post( data.url, data ).then( result => {
					if ( result.data.data ) {
						this.run( result.data.data );
					} else {
						MigrationData.shift();
						Migration.Do();
					}
				}).catch( error => {
					$( '#migration-progress' ).append( `<p>&mdash; ${textDomain.anErrorOccured} : ${error.response.message}` );
				})
			}
		};
		//if there is no migration
		if( MigrationData.length == 0 ) {
			$( '#migration-progress' ).append( '<p>' + '<?php _e('No migration content available');?>' + '</p>' );
			document.location = '<?php echo site_url(array( 'admin', 'addons?highlight=' . $addon[ 'application' ][ 'namespace' ] . '&notice=migration-not-required' ));?>';
		} 
        else {
			Migration.Do();
		}
    });
	</script>
<?php else :
    echo '<p>' . __('Migrate not available for this addon.') . '</p>';
endif; ?>
</div>