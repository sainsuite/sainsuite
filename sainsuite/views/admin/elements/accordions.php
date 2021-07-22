<div class="accordion accordion-light accordion-toggle-arrow" id="accordion">

<?php foreach (riake('accordion', $_item) as $index => $_row) : 
    if( @$_row[ 'permission' ] != null && ! User::is_allowed( $_row[ 'permission' ] ) ) {
        continue;
    } 
    ?>
    <div class="card gutter-b">
        <div class="card-header <?php echo riake('class', $_row);?>" id="heading<?php echo $_row['id'];?>" data-toggle="collapse" data-target="#collapse<?php echo $_row['id'];?>">
            <div class="card-title pb-0 d-flex flex-column align-items-start">
                <h4><?php echo riake('heading', $_row);?></h4>
            </div>
            <p><?php echo riake('description', $_row);?></p>
        </div>

		<div id="collapse<?php echo $_row['id'];?>" class="collapse <?php echo (riake('show', $_row)) ? 'show' : ''; ?>" data-parent="#accordion">
			<div class="card-body px-0 px-sm-5">            
                <?php echo $this->load->admin_view('elements/_init', array( 'meta' => $_row['body'] ), true);?>

                <?php if (riake('hide_footer', $_row) == false) : ?>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" onclick="checkRequiredFields(this)" class="btn btn-primary font-weight-bolder mr-2">
                            <span class="position-relative"><?php _e('Save changes' ) ?></span>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
			</div>
		</div>
	</div>
    <?php 
endforeach;?>
</div>