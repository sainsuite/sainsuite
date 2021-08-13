<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @author	    Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */
    
?>

<div class="d-flex flex-column-fluid" id="ss_data">
    <div class="container">
        
        <div class="<?php echo $this->events->apply_filters('fill_mobile_toggle_row', 'row');?>">
        <?php foreach (force_array($this->polatan->get_cols()) as $col_id => $col_data):?>
        <?php if (riake('class', $col_data)) : ?>
        <div class="<?php echo riake('class', $col_data);?>" id="<?php echo riake('id', $col_data);?>" style="<?php echo riake('style', $col_data);?>">
        <div class="row"> 
        <?php endif;?>

        <?php foreach (force_array(riake('metas', $col_data)) as $meta) : ?>
            <?php if(riake('class', $meta)) : ?>
            <div class="<?php echo riake('class', $meta);?>" id="<?php echo riake('id', $meta);?>">
            <?php endif;?>

                <?php 
                // enable gui form saver
                $form_expire   = gmt_to_local(time(), 'UTC') + GUI_EXPIRE;
                $icon          = riake('icon', $meta, false);
                $ref           = urlencode(current_url());
                $id            = riake('id', riake('form', $meta));
                $class         = riake('classes', riake('form', $meta), 'required-form');
                $action        = riake('action', riake('form', $meta), site_url(array( 'admin', 'options', 'save' )));
                $method        = riake('method', riake('form', $meta), 'POST');
                $enctype       = riake('enctype', riake('form', $meta), 'multipart/form-data');
                $namespace     = riake('namespace', $meta);
                $use_namespace = riake('use_namespace', $meta, false);
                ?>

                <?php if ( riake('gui_saver', $meta)) :?>
                <form ng-non-bindable 
                    autocomplete="off"
                    class="form <?php echo $class;?>" 
                    id="<?php echo $id;?>"
                    action="<?php echo $action;?>" 
                    enctype="<?php echo $enctype;?>" 
                    method="<?php echo $method;?>">
                    <input type="hidden" name="gui_saver_user_id" value="<?php echo @$meta[ 'user_id' ];?>" />
                    <input type="hidden" name="gui_saver_ref" value="<?php echo $ref;?>" />
                    <input type="hidden" name="gui_saver_option_namespace" value="<?php echo riake('namespace', $meta);?>" />
                    <input type="hidden" name="gui_saver_expiration_time" value="<?php echo $form_expire;?>" />
                    <input type="hidden" name="gui_saver_use_namespace" value="<?php echo $use_namespace ? 'true' : 'false';?>" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <?php elseif (in_array($action, array( null, false ), true)) :?>
                <form ng-non-bindable 
                    autocomplete="off"
                    class="form <?php echo $class;?>" 
                    id="<?php echo $id;?>"
                    enctype="<?php echo $enctype;?>" 
                    method="<?php echo $method;?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <?php endif; ?>

                    <?php if (in_array($meta_type = riake('type', $meta), array( 'card' ))) : ?>
                    <div class="card card-custom <?php echo riake('card', $meta, 'card-px-0 border-0') ;?> gutter-b">
                        <?php if ($header = riake('header', $meta)) : ?>
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <?php if (riake('icon', $header)):?>
                                <span class="card-icon">
                                    <i class="flaticon2-line-chart text-primary"></i>
                                </span>
                                <?php endif;?>
                                <h3 class="card-label font-weight-bolder "><?php echo riake('title', $header);?></h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1"><?php echo riake('sub_title', $header);?></span>
                            </div>
                        </div>
                        <?php endif;?>

                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $this->load->admin_view('elements/_init', array(
                                        'namespace' => $namespace,
                                        'meta' => $meta
                                    ), true);?>
                                </div>
                            </div>
                        </div>

                        <?php if ($footer = riake('footer', $meta)) : ?>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" onclick="checkRequiredFields(this)" class="btn btn-primary font-weight-bolder mr-2">
                                        <span class="position-relative"><?php echo ($footer == 'add') ? __('Save New') : __('Save changes');?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                    <?php else : ?>

                    <?php echo $this->load->admin_view('elements/_init', array(
                        'namespace' => $namespace,
                        'meta' => $meta
                    ), true);?>
                    <?php endif; ?>

                <?php if (riake('gui_saver', $meta) || in_array($action, array( null, false ), true) ) :?>
                </form>
                <?php endif;?>
                
            <?php if(riake('class', $meta)) : ?>
            </div>
            <?php endif;?>
        <?php endforeach;?>

        <?php if (riake('class', $col_data)) : ?>
        </div></div>
        <?php endif;?>
        <?php endforeach;?>
        </div>

    </div>
</div>
