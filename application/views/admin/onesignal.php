<?php  ?>

<div class="row">
    <div class="col-lg-5 col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 style="font-size: 18px; font-weight: 600; margin-top:0;"><?php echo trans('send_notification'); ?></h3>
            </div>
            <?php if (active_onesignal()): ?>
              <!-- form start -->
              <?php echo form_open('admin_controller/onesignal'); ?>

              <div class="box-body">
                  <!-- include message block -->
                  <?php $this->load->view('admin/includes/_messages'); ?>

                  <?php if ($this->general_settings->onesignal_test_mode): ?>
                    <div class="alert alert-warning" role="alert" style="width:100%; margin-bottom: 15px !important">
                      ONESIGNAL TEST MODE - ACTIVE
                    </div>
                  <?php endif; ?>

                  <div class="form-group">
                      <label class="label-sitemap"><?php echo trans('onesignal_message'); ?></label>
                      <textarea name="message" id="message" class="form-control" rows="5" minlength="6" maxlength="500" required></textarea>
                      <small>Max: <span id="max">500</span></small>
                  </div>
                  <div class="form-group">
                      <label><?php echo trans("onesignal_segments"); ?></label>
                      <select name="segment" class="form-control">
                          <option value=""><?php echo trans("segment_all_users"); ?></option>
                          <option value="Subscribed Users"><?php echo trans("segment_subscribed_users"); ?></option>
                          <option value="Active Users"><?php echo trans("segment_active_users"); ?></option>
                          <option value="Inactive Users"><?php echo trans("segment_inactive_users"); ?></option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('url'); ?></label>
                    <div class="input-group">
                      <div class="input-group-addon" style="background-color: #eee"><?=base_url()?></div>
                      <input type="text" name="url" class="form-control" placeholder="urun-url..">
                    </div>
                  </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <button type="submit" class="btn btn-primary pull-right" disabled><?php echo trans('send_notification'); ?></button>
              </div>
              <!-- /.box-footer -->
              <?php echo form_close(); ?><!-- form end -->
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-7 col-sm-12" id="onesignal_table">
      <div style="padding: 20px 10px; text-align:center;">
        <h4><?=trans('please_wait')?></h4>
      </div>
    </div>
</div>
<script type="text/javascript">
  $('#message').on('keyup keydown paste change keypress', function () {
    $('form').find('button[type=submit]').attr('disabled', 'disabled');
    if (this.value.length >= 6) {
      $('form').find('button[type=submit]').removeAttr('disabled');
    }
    $('#max').text(500 - this.value.length);
  });
  $('form').on('submit', function(event) {
    $(this).find('button[type=submit]').attr('disabled', 'disabled').text('<?php echo trans('please_wait'); ?>');
  });
  setTimeout(function() {
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/onesignal_notifications",
        data: {},
        dataType:'html',
        success: function (response) {
            $('#onesignal_table').html(response);
        }
    });
  }, 250);
</script>
