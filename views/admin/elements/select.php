<?php $multiple = ($col_type == 'multiple') ? $col_type : ''; ?>

<select class="form-control select2" 
    <?php echo $multiple; ?> 
    <?php echo riake('readonly', $col) === true ? 'readonly' : '';?>
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
            if (! is_array($active = riake('active', $col)) ) {
                $selected = ($active == $value && ! empty($active)) ? 'selected="selected"' : '';
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
        var val1=data.replace('[','');
        var val2=val1.replace(']','');
        $.each(val2.split(","), function(i,e){
            var d=e.replace('"','');
            var k=d.replace('"','');
            $(".select2 option[value='" + k + "']").prop("selected", true).trigger('change');
        });
    }
});
</script>
<?php endif; ?>