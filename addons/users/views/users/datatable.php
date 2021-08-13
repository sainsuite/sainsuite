<script>
var DatatableScript = function() {   
    // Read
    var read = function() {
        var datatable = $('#ss_datatable').SSDatatable({
			data: {
				type: 'remote',
                source: '<?php echo site_url(['api', 'users']);?>',
				pageSize: 20, // display 20 records per page
			},

            search: {
                input: $('#search_query'),
                key: 'generalSearch'
            },  

            // columns definition
            columns: [
                {
                    field: 'checkbox',
                    title: '',
                    template: '{{user_id}}',
                    sortable: false,
                    width: 20,
                    textAlign: 'center',
                    selector: {class: 'ss-checkbox--solid'},
                }, {
                    field: 'username',
                    title: 'User',
					overflow: 'visible',
                    template: function(row) {
                        var stateNo = SSUtil.getRandomInt(0, 7);
                        var states = [
                            'success',
                            'primary',
                            'danger',
                            'success',
                            'warning',
                            'dark',
                            'primary',
                            'info'];
                        var state = states[stateNo];

                        output = '<div class="d-flex align-items-center">\
                            <div class="symbol symbol-40 symbol-'+state+' flex-shrink-0">\
                                <div class="symbol-label">' + row.username.substring(0, 1) + '</div>\
                            </div>\
                            <div class="ml-2">\
                                <div class="text-dark-75 font-weight-bold line-height-sm">' + row.username + '</div>\
                                <a href="#" class="font-size-sm text-dark-50 text-hover-primary">' +
                                row.group + '</a>\
                            </div>\
                        </div>';

						return output;
                    }
                }, {
                    field: 'email',
                    title: 'Email',
                    responsive: {
                        visible: 'md'
                    }
                }, {
                    field: 'last_login',
                    title: 'Last Login',
                }, {
                    field: 'last_activity',
                    title: 'Last Activity',
					template: function(row) {
						return (row.last_activity) ? moment(row.last_activity).fromNow(true) : '-';
					},
                }, {
                    field: 'banned',
                    title: 'Status',
					template: function(row) {
						var banned = {
							0 : {'title': 'Active', 'class': ' label-light-primary'},
							1 : {'title': 'Inactive', 'class': ' label-light-danger'},
						};
						return '<span class="label font-weight-bold label-lg ' + banned[row.banned].class + ' label-inline">' + banned[row.banned].title + '</span>';
					},
                }, 
                <?php echo $this->events->do_action('do_users_columns'); ?>
                {
					field: 'Actions',
					title: 'Actions',
                    textAlign: 'right',
					sortable: false,
                    width: 100,
					overflow: 'visible',
                    autoHide: false,
					template: function(row) {
                        var edit  = '<button class="btn btn-sm btn-icon btn-light" disabled><i class="fas fa-pen"></i></button>';
                        var hapus = '<button class="btn btn-sm btn-icon btn-light" disabled><i class="fas fa-trash-alt"></i></button>';
                        if (<?php echo User::id(); ?> == row.user_id) {
						edit = '\<a class="btn btn-sm btn-icon btn-light-primary btn-hover-primary "\
                                href="<?php echo site_url(array( 'admin', 'users', 'edit'));?>/'+ row.user_id +'">\
                                <i class="fas fa-user"></i>\
                            </a>';
                        hapus = '';                        
                        } else {
                            <?php if ( User::is_allowed('edit.users')) : ?>
                            edit = '\<a class="btn btn-sm btn-icon btn-light-primary btn-hover-primary "\
                                    href="<?php echo site_url(array( 'admin', 'users', 'edit'));?>/'+ row.user_id +'">\
                                    <i class="fas fa-pen"></i>\
                                </a>';
                            <?php endif; ?>

                            <?php if ( User::is_allowed('delete.users')) : ?>
                            hapus = '\<button class="btn btn-sm btn-icon btn-light-danger btn-hover-danger "\
                                    data-head="<?php echo _s( 'Would you like to delete this data?' ) ;?>"\
                                    data-url="<?php echo site_url(array( 'admin', 'users', 'delete'));?>/'+ row.user_id +'"\
                                    onclick="deleteConfirmation(this)">\
                                    <i class="fas fa-trash-alt"></i>\
                                </button>';
                            <?php endif; ?>
                        }

                        return '<div class="btn-group">'+ edit +' '+ hapus +'</div>';
					},
				},
            ],
        });

        $('#ss_datatable_search_group').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'group');
        });

        $('#ss_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'banned');
        });
    };

    return {
        init: function() {
            read();
        },
    };

}();

jQuery(document).ready(function() {
    DatatableScript.init();
});
</script>