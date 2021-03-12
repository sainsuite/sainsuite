<?php $multiple = $col_type == 'multiple' ? $col_type : ''; ?>

<select class="form-control <?php echo ($multiple) ? 'selectpicker' : ''; ?> <?php echo riake('widget', $col);?>" 
    data-live-search="true"
    <?php echo $multiple; ?> 
    <?php echo riake('disabled', $col) === true ? 'disabled="disabled"' : '';?>
    <?php echo riake('required', $col) === true ? 'required' : '';?>
    <?php echo riake('attr', $col);?>
    id="<?php echo riake('id', $col);?>" 
    name="<?php echo riake('name', $col);?>" 
    title="<?php echo riake('label', $col);?>">
    <?php
    foreach (force_array(riake('options', $col)) as $value => $text) {
        if (riake('gui_saver', $meta) === true  && in_array(riake('action', riake('form', $meta)), array( null, false ))) {
            $selected = $db_value == $value ? 'selected="selected"' : '';
        } else {
            if (! is_array($active = riake('active', $col))) {
                $selected = $active == $value ? 'selected="selected"' : '';
            } else {
                $selected = in_array($value, $active) ? 'selected="selected"' : '';
            }
        }
        ?>
        <option <?php echo $selected;?><?php echo set_select(riake('name', $col), $value, False); ?> value="<?php echo xss_clean( strip_tags( $value ) );?>"> <?php echo $text;?></option>
        <?php
    }
    ?>
</select>

<?php if ( $multiple ) :  ?>
<script>
$.ajax({
    url: "<?php echo riake('url', $_item);?>",
    method: "POST",
    data :{<?php echo riake('data', $_item) ;?>},
    cache:false,
    success : function(data){
        var item=data;
        var val1=item.replace('[','');
        var val2=val1.replace(']','');
        var values=val2;
        $.each(values.split(","), function(i,e){
            var d=e.replace('"','');
            var k=d.replace('"','');
            $(".strings option[value='" + k + "']").prop("selected", true).trigger('change');
            $(".strings").selectpicker('refresh');
        });
    }
});
</script>
<?php endif; ?>