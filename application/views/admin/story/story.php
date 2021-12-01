<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_story_item'); ?></h3>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/add_story_item_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata("msg_settings"))):
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($this->languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($this->selected_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('link'); ?></label>
                    <input type="text" class="form-control" name="link" placeholder="<?php echo trans('link'); ?>"
                           value="<?php echo old('link'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="row row-form">
                    <div class="col-sm-12 col-md-6 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('sort'); ?></label>
                            <input type="number" class="form-control" name="item_order" placeholder="<?php echo trans('sort'); ?>"
                                   value="<?php echo old('item_order'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('status'); ?></label>
                            <select name="status" class="form-control" required>
                                <option value="1" selected><?php echo trans('active'); ?></option>
                                <option value="0"><?php echo trans('passive'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Avatar (256x256)</label>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file_avatar" size="40" accept=".png, .jpg, .jpeg, .gif" required onchange="show_preview_image(this);">
                        </a>
                    </div>
                    <img src="<?php echo IMG_BASE64_1x1; ?>" id="img_preview_file_avatar" class="img-file-upload-preview">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?> (900x1600)</label>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" required onchange="show_preview_image(this);">
                        </a>
                    </div>
                    <img src="<?php echo IMG_BASE64_1x1; ?>" id="img_preview_file" class="img-file-upload-preview">
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_story_item'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('story_items'); ?></h3>
            </div><!-- /.box-header -->

            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="cs_datatable_lang" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th>Avatar</th>
                                    <th><?php echo trans('image'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('sort'); ?></th>
                                    <th><?php echo trans('status'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($story_items as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td>
                                            <img src="<?php echo base_url() . $item->avatar; ?>" alt="" style="height: 64px; width:64px; border-radius: 50%"/>
                                        </td>
                                        <td>
                                            <img src="<?php echo base_url() . $item->image; ?>" alt="" style="height: 90px;"/>
                                        </td>
                                        <td><?php echo $item->title; ?></td>
                                        <td>
                                            <?php
                                            $language = get_language($item->lang_id);
                                            if (!empty($language)) {
                                                echo $language->name;
                                            } ?>
                                        </td>
                                        <td><?php echo $item->item_order; ?></td>
                                        <td>
                                          <?php if ($item->status == 1): ?>
                        										<label class="label label-success"><?php echo trans("active"); ?></label>
                        									<?php else: ?>
                        										<label class="label label-danger"><?php echo trans("passive"); ?></label>
                        									<?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-story-item/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_story_item_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
