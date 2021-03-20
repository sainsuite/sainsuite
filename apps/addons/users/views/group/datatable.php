<script>
var DatatableScript = function() {   
    // Read
    var read = function() {
        var array = '<?php echo $groups;?>';
        var dataSet;
        if (Object.keys(array).length) {
            dataSet = JSON.parse(array);
        }
        var datatable = $('#kt_datatable').KTDatatable({
			data: {
				type: 'local',
				source: dataSet,
				pageSize: 10, // display 20 records per page
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
                    selector: {class: 'kt-checkbox--solid'},
                }, {
                    field: 'username',
                    title: 'User',
                    width: 200,
                    template: function(row) {
                        var stateNo = KTUtil.getRandomInt(0, 7);
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
                        <?php if ( User::control('edit.group')) : ?>
						edit = '\
                            <a class="btn btn-sm btn-icon btn-light-primary btn-hover-primary "\
                                href="<?php echo site_url(array( 'admin', 'group', 'edit'));?>/'+ row.id +'">\
                                <i class="fas fa-pen"></i>\
                            </a>\
                        ';
                        <?php endif; ?>

                        <?php if ( User::control('delete.group')) : ?>
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
            ],
        });
        
        datatable.on(
            'datatable-on-check datatable-on-uncheck',
            function(e) {
                var checkedNodes = datatable.rows('.datatable-row-active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_records').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            }
        );
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