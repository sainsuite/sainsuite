<script>
var DatatableScript = function() {   
    // Read
    var read = function() {
        var datatable = $('#ss_datatable').SSDatatable({
			data: {
				type: 'remote',
                source: '<?php echo site_url(['api', 'groups']);?>',
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
                    template: '{{id}}',
                    sortable: false,
                    width: 20,
                    textAlign: 'center',
                    selector: {class: 'ss-checkbox--solid'},
                }, {
                    field: 'username',
                    title: 'User',
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

                        var output = '<div class="d-flex align-items-center">\
                            <div class="symbol symbol-30 symbol-'+state+' flex-shrink-0">\
                                <div class="symbol-label">' + row.name.substring(0, 1) + '</div>\
                            </div>\
                            <div class="ml-2">\
                                <div class="text-dark-75 font-weight-bold line-height-sm">' + row.name + '</div>\
                            </div>\
                        </div>';

						return output;
                    }
                }, {
                    field: 'definition',
                    title: 'Definition',
                    width: 200,
                }, {
                    field: '',
                    title: 'Status',
                    width: 200,
					template: function(row) {
						return '<span class="label font-weight-bold label-lg label-light-primary label-inline">Active</span>';
					},
                }, {
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
                        <?php if ( User::is_allowed('edit.group')) : ?>
						edit = '\
                            <a class="btn btn-sm btn-icon btn-light-primary btn-hover-primary "\
                                href="<?php echo site_url(array( 'admin', 'group', 'edit'));?>/'+ row.id +'">\
                                <i class="fas fa-pen"></i>\
                            </a>\
                        ';
                        <?php endif; ?>

                        <?php if ( User::is_allowed('delete.group')) : ?>
                        hapus = '\
                            <button class="btn btn-sm btn-icon btn-light-danger btn-hover-danger "\
                                data-head="<?php echo _s( 'Would you like to delete this data?' ) ;?>"\
                                data-url="<?php echo site_url(array( 'admin', 'group', 'delete'));?>/'+ row.id +'"\
                                onclick="deleteConfirmation(this)">\
                                <i class="fas fa-trash-alt"></i>\
                            </button>\
                        ';
                        <?php endif; ?>

                        return '<div class="btn-group">'+ edit +' '+ hapus +'</div>';
					},
				}
            ]
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