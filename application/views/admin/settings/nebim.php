<?php  ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?php echo trans('nebim_settings'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-7 col-md-12 col-sm-12">
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
                      <small>??rne??in; http://93.182.75.201:2366/ - Sonu / i??areti bitmeli!</small>
                  </div>

                  <hr>

                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('nebim_renk_customfield'); ?></label>
                      <select class="form-control" name="nebim_renk_customfield">
                        <option value=""><?=trans('choose_option')?></option>
                        <?php foreach ($custom_fields = $this->field_model->get_fields() as $key => $field): ?>
                          <option value="<?=$field->id?>" <?=$this->general_settings->nebim_renk_customfield == $field->id ? 'selected':''?>>
                            <?=parse_serialized_name_array($field->name_array, $this->selected_lang->id)?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('nebim_beden_customfield'); ?></label>
                      <select class="form-control" name="nebim_beden_customfield">
                        <option value=""><?=trans('choose_option')?></option>
                        <?php foreach ($custom_fields = $this->field_model->get_fields() as $key => $field): ?>
                          <option value="<?=$field->id?>" <?=$this->general_settings->nebim_beden_customfield == $field->id ? 'selected':''?>>
                            <?=parse_serialized_name_array($field->name_array, $this->selected_lang->id)?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                  </div>

                  <hr>

                  <div class="form-group">
                      <label class="control-label"><?php echo trans('nebim_image_settings'); ?></label>
                      <div class="row">
                          <?php
                          $images = json_decode($this->general_settings->nebim_images_sync, true);
                          for ($image = 1; $image <= 8; $image++) :
                            $attr = '';
                            if ($image <= 4) {
                              $attr = 'checked disabled';
                            }
                            if ($images && in_array($image, $images)) {
                              $attr = 'checked';
                            }
                            ?>
                            <div class="col-sm-2">
                                <input type="checkbox" name="nebim_images_sync[]" value="<?=$image?>" class="square-purple" <?=$attr?>>
                                <label class="option-label">Image<?=$image?></label>
                            </div>
                          <?php endfor; ?>
                      </div>
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
