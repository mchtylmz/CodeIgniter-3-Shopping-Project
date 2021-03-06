<?php  ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?php echo trans('cache_system'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("product_cache_system"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/product_cache_system_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata('msg_category'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="product_cache_system" value="1" id="cache_system_1"
                                   class="square-purple" <?php echo ($this->general_settings->product_cache_system == 1) ? 'checked' : ''; ?>>
                            <label for="cache_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="product_cache_system" value="0" id="cache_system_2"
                                   class="square-purple" <?php echo ($this->general_settings->product_cache_system != 1) ? 'checked' : ''; ?>>
                            <label for="cache_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?php echo trans('refresh_cache_database_changes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="refresh_cache_database_changes" value="1" id="refresh_cache_database_changes_1"
                                   class="square-purple" <?php echo ($this->general_settings->refresh_cache_database_changes == 1) ? 'checked' : ''; ?>>
                            <label for="refresh_cache_database_changes_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="refresh_cache_database_changes" value="0" id="refresh_cache_database_changes_2"
                                   class="square-purple" <?php echo ($this->general_settings->refresh_cache_database_changes != 1) ? 'checked' : ''; ?>>
                            <label for="refresh_cache_database_changes_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('cache_refresh_time'); ?></label>&nbsp;
                    <small>(<?php echo trans("cache_refresh_time_exp"); ?>)</small>
                    <input type="number" class="form-control" name="cache_refresh_time" placeholder="<?php echo trans('cache_refresh_time'); ?>"
                           value="<?php echo($this->general_settings->cache_refresh_time / 60); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    <button type="submit" name="action" value="reset" class="btn btn-warning pull-right m-r-10"><?php echo trans('reset_cache'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("static_content_cache_system"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/static_content_cache_system_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_category'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="static_content_cache_system" value="1" id="static_content_cache_system_1"
                                   class="square-purple" <?php echo ($this->general_settings->static_content_cache_system == 1) ? 'checked' : ''; ?>>
                            <label for="static_content_cache_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="static_content_cache_system" value="0" id="static_content_cache_system_2"
                                   class="square-purple" <?php echo ($this->general_settings->static_content_cache_system != 1) ? 'checked' : ''; ?>>
                            <label for="static_content_cache_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    <button type="submit" name="action" value="reset" class="btn btn-warning pull-right m-r-10"><?php echo trans('reset_cache'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
        <div class="alert alert-info alert-large">
            <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("warning_static_content_cache_system"); ?>
        </div>
    </div>
</div>
