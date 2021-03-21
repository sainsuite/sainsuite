<!--begin: Selected Rows Group Action Form-->
<div class="mb-5 collapse" id="kt_datatable_group_action_form">
    <div class="d-flex align-items-center">
        <div class="font-weight-bold text-danger mr-3">
            Selected <span id="kt_datatable_selected_records">0</span> records:
        </div>

        <button class="btn btn-sm btn-danger mr-2" type="button" onclick="deleteConfirmation(this)">
            Delete All
        </button>
    </div>
</div>
<!--end: Selected Rows Group Action Form-->

<!--begin::Datatable-->
<div id="kt_datatable" class="datatable datatable-bordered datatable-head-custom"></div>
<!--end::Datatable-->