<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-lg-5 col-md-12">
		<div class="box box-primary">
			<!-- /.box-header -->
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo trans('update_slider_item'); ?></h3>
			</div><!-- /.box-header -->

			<!-- form start -->
			<?php echo form_open_multipart('admin_controller/update_story_item_post'); ?>
			<input type="hidden" name="id" value="<?php echo $item->id; ?>">

			<div class="box-body">
				<!-- include message block -->
				<?php $this->load->view('admin/includes/_messages'); ?>

				<div class="form-group">
					<label><?php echo trans("language"); ?></label>
					<select name="lang_id" class="form-control">
						<?php foreach ($this->languages as $language): ?>
							<option value="<?php echo $language->id; ?>" <?php echo ($item->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo trans('title'); ?></label>
					<input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>" value="<?php echo html_escape($item->title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo trans('link'); ?></label>
					<input type="text" class="form-control" name="link" placeholder="<?php echo trans('link'); ?>" value="<?php echo $item->link; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>

				<div class="row row-form">
					<div class="col-sm-12 col-md-6 col-form">
						<div class="form-group">
							<label class="control-label"><?php echo trans('sort'); ?></label>
							<input type="number" class="form-control" name="item_order" placeholder="<?php echo trans('sort'); ?>" value="<?php echo $item->item_order; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-form">
						<div class="form-group">
								<label class="control-label"><?php echo trans('status'); ?></label>
								<select name="status" class="form-control" required>
										<option value="1" <?=$item->status == '1' ? 'selected':''?>><?php echo trans('active'); ?></option>
										<option value="0" <?=$item->status != '1' ? 'selected':''?>><?php echo trans('passive'); ?></option>
								</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Avatar (256x256)</label>
					<div class="display-block m-b-15">
						<img src="<?php echo base_url() . $item->avatar; ?>" alt="" class="img-responsive" style="max-width: 300px; max-height: 300px;">
					</div>
					<div class="display-block">
						<a class='btn btn-success btn-sm btn-file-upload'>
							<?php echo trans('select_image'); ?>
							<input type="file" name="file_avatar" accept=".png, .jpg, .jpeg, .gif" onchange="show_preview_image(this);">
						</a>
					</div>
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" id="img_preview_file_avatar" class="img-file-upload-preview">
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo trans('image'); ?> (900x1600)</label>
					<div class="display-block m-b-15">
						<img src="<?php echo base_url() . $item->image; ?>" alt="" class="img-responsive" style="max-width: 300px; max-height: 300px;">
					</div>
					<div class="display-block">
						<a class='btn btn-success btn-sm btn-file-upload'>
							<?php echo trans('select_image'); ?>
							<input type="file" name="file" accept=".png, .jpg, .jpeg, .gif" onchange="show_preview_image(this);">
						</a>
					</div>
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" id="img_preview_file" class="img-file-upload-preview">
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
			</div>
			<!-- /.box-footer -->
			<?php echo form_close(); ?><!-- form end -->
		</div>
	</div>
</div>
