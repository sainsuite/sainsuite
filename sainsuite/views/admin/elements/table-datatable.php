<!--begin: Selected Rows Group Action Form-->
<div class="mb-5 collapse" id="ss_datatable_group_action_form">
    <div class="d-flex align-items-center">
        <div class="font-weight-bold text-danger mr-3">
            Selected <span id="ss_datatable_selected_records">0</span> records:
        </div>

        <button class="btn btn-sm btn-danger mr-2" type="button" onclick="deleteConfirmation(this)">
            Delete All
        </button>
    </div>
</div>
<!--end: Selected Rows Group Action Form-->

<!--begin::Datatable-->
<div id="ss_datatable" class="datatable datatable-bordered datatable-head-bg"></div>
<!--end::Datatable-->