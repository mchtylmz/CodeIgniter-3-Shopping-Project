<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?php echo trans('nebim_settings'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <?php if (active_nebimv3()): ?>
              <!-- form start -->
              <?php echo form_open('admin_controller/nebim_settings'); ?>

              <div class="box-body">
                  <!-- include message block -->
                  <?php $this->load->view('admin/includes/_messages'); ?>

                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('nebim_office_code'); ?></label>
                      <input type="text" class="form-control" name="nebim_office_code"
                             placeholder="..."
                             value="<?php echo $this->general_settings->nebim_office_code; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                  </div>
                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('nebim_store_code'); ?></label>
                      <input type="text" class="form-control" name="nebim_store_code"
                             placeholder="..."
                             value="<?php echo $this->general_settings->nebim_store_code; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                  </div>
                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('nebim_warehouse_code'); ?></label>
                      <input type="text" class="form-control" name="nebim_warehouse_code"
                             placeholder="..."
                             value="<?php echo $this->general_settings->nebim_warehouse_code; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                  </div>
                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('nebim_integrator_url'); ?></label>
                      <input type="url" class="form-control" name="nebim_integrator_url"
                             placeholder="http://..."
                             value="<?php echo $this->general_settings->nebim_integrator_url; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                      <small>Örneğin; http://93.182.75.201:2366/ - Sonu / işareti bitmeli!</small>
                  </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
              </div>
              <!-- /.box-footer -->
              <?php echo form_close(); ?><!-- form end -->
            <?php endif; ?>
        </div>
    </div>
</div>
