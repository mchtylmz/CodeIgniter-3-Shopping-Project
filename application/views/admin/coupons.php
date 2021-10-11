<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.tr.min.js" integrity="sha512-fIZStvQgU9hAKeI9ovYv2kAv8oBsXHmxoea+RHi3684K1jriiTSvcjF+h0iRzkaZWC8NlmPGd4SIlCIx9uRdCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary" style="<?php echo isset($coupon->code) ? 'border: solid 2px #f1b740':''; ?>">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo isset($coupon->code) ? trans('coupon_update') . ' - ' . $coupon->code:trans('coupon_add'); ?></h3>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/coupons'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata("msg_settings"))):
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('coupon_code'); ?></label>
                    <input type="text" class="form-control" style="text-transform:uppercase" name="code" placeholder="<?php echo trans('coupon_code'); ?>"
                           value="<?php echo old('code') ?? ($coupon->code ?? ''); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('coupon_type'); ?></label>
                        <?php $coupon_type = old('type') ?? ($coupon->type ?? ''); ?>
                        <select name="type" class="form-control" required>
                            <option value="percent" <?php echo ($coupon_type == 'percent') ? 'selected' : ''; ?>><?php echo trans('coupon_percent'); ?></option>
                            <option value="money" <?php echo ($coupon_type == 'money') ? 'selected' : ''; ?>><?php echo trans('coupon_money'); ?></option>
                        </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('discount'); ?></label>
                        <input type="number" step="0.01" class="form-control" name="discount" placeholder="<?php echo trans('discount'); ?>"
                               value="<?php echo old('discount') ?? ($coupon->discount ?? ''); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    </div>
                  </div>
                </div> <!-- row -->

                <div class="form-group">
                    <label class="control-label"><?php echo trans('language'); ?></label>
                    <?php $coupon_lang = old('lang') ?? ($coupon->lang ?? ''); ?>
                    <select name="lang" class="form-control" required>
                      <option value=""><?php echo trans('language'); ?>....</option>
                      <?php if ($languages = get_languages()): ?>
                        <?php foreach ($languages as $key => $lang): ?>
                          <option value="<?=$lang->short_form?>" <?php echo ($coupon_lang == $lang->short_form) ? 'selected' : ''; ?>><?=$lang->name?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('date'); ?></label>
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="form-control" name="start_date" value="<?php echo old('start_date') ?? ($coupon->start_date ?? ''); ?>" autocomplete="off" required>
                      <span class="input-group-addon"> - </span>
                      <input type="text" class="form-control" name="expire_date" value="<?php echo old('expire_date') ?? ($coupon->expire_date ?? ''); ?>" autocomplete="off" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="1"
                                   class="square-purple" <?php echo ((isset($coupon->status) && $coupon->status == '1') || old("status") == 1 || old("status") == "") ? 'checked' : ''; ?>>
                            <label for="page_enabled" class="option-label"><?php echo trans('active'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="0"
                                   class="square-purple" <?php echo ((isset($coupon->status) && $coupon->status == '0') || old("status") == 0 && old("status") != "") ? 'checked' : ''; ?>>
                            <label for="page_disabled" class="option-label"><?php echo trans('passive'); ?></label>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php if (isset($coupon->id)): ?>
                  <input type="hidden" name="id" value="<?=$coupon->id?>">
                <?php endif; ?>
                <button type="submit" class="btn <?php echo isset($coupon->code) ? 'btn-warning':'btn-primary'; ?> pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('coupons'); ?></h3>
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
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('coupon_code'); ?></th>
                                    <th><?php echo trans('discount'); ?></th>
                                    <th><?php echo trans('status'); ?></th>
                                    <th><?php echo trans('date'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($coupons as $key => $coupon): ?>
                                    <tr>
                                        <td><?php echo html_escape($coupon->lang); ?></td>
                                        <td><?php echo html_escape($coupon->code); ?></td>
                                        <td>
                                          <?=$coupon->type == 'percent' ? 'Yüzde':'Miktar'?> - <?php echo $coupon->discount; ?>
                                        </td>
                                        <td>
                                          <?php if ($coupon->status == 1): ?>
                        										<label class="label label-success"><?php echo trans("active"); ?></label>
                        									<?php else: ?>
                        										<label class="label label-danger"><?php echo trans("passive"); ?></label>
                        									<?php endif; ?>
                                        </td>
                                        <td>
                                          <span><?=date('d/m/Y', strtotime($coupon->start_date))?></span>
                                          <br>
                                          <span><?=date('d/m/Y', strtotime($coupon->expire_date))?></span>
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
                                                        <a href="<?php echo admin_url(); ?>coupons?id=<?php echo html_escape($coupon->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/coupon_delete','<?php echo $coupon->id; ?>','<?php echo trans("confirm_option"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
<script type="text/javascript">
$('.input-daterange').datepicker({
  clearBtn: true,
  format: 'yyyy-mm-dd',
  language: 'tr',
  startDate: '<?=date('Y-m-d')?>',
  disableTouchKeyboard: true,
  calendarWeeks: true
});
$("form").submit(function(){
  $('button[type=submit]').attr('disabled', 'disabled');
});
</script>
