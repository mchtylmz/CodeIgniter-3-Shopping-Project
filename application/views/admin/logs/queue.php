<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style media="screen">
  tr, td:not(.text-left), th:not(.text-left) {
    text-align: center;
  }
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans("queue_logs"); ?></h3>
        </div>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <div class="row table-filter-container">
                          <div class="col-sm-12">
                              <?php echo form_open('', ['method' => 'GET']); ?>

                              <div class="item-table-filter" style="width: 132px; min-width: 132px;">
                                  <label><?php echo trans("queue_method"); ?></label>
                                  <select name="method" class="form-control">
                                      <option value="">Tümü</option>
                                      <option value="user_id" <?php echo ($this->input->get('method', true) == 'user_id') ? 'selected' : ''; ?>>Kullanıcı</option>
                                      <option value="order_id" <?php echo ($this->input->get('method', true) == 'order_id') ? 'selected' : ''; ?>>Sipariş</option>
                                  </select>
                              </div>

                              <div class="item-table-filter" style="width: 132px; min-width: 132px;">
                                  <label><?php echo trans("status"); ?></label>
                                  <select name="status" class="form-control">
                                      <option value="">Tümü</option>
                                      <option value="1" <?=$this->input->get('status', true) == '1' ? 'selected' : ''?>>waiting</option>
                                      <option value="2" <?=$this->input->get('status', true) == '2' ? 'selected' : ''?>>processing</option>
                                      <option value="3" <?=$this->input->get('status', true) == '3' ? 'selected' : ''?>>complete</option>
                                      <option value="4" <?=$this->input->get('status', true) == '4' ? 'selected' : ''?>>failed</option>
                                      <option value="5" <?=$this->input->get('status', true) == '5' ? 'selected' : ''?>>pass</option>
                                  </select>
                              </div>

                              <div class="item-table-filter" style="min-width: 180px;">
                                  <label><?php echo trans("search"); ?></label>
                                  <input name="q" class="form-control" placeholder="...." type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <input type="hidden" name="user" value="<?=$this->input->get('user', true)?>">
                              <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                  <label style="display: block">&nbsp;</label>
                                  <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
                              </div>
                              <?php echo form_close(); ?>
                          </div>
                      </div>
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans("id"); ?></th>
                            <th><?php echo trans("queue_method"); ?></th>
                            <th class="text-left"><?php echo trans("queue_detail"); ?></th>
                            <th><?php echo trans("queue_attempt"); ?></th>
                            <th><?php echo trans("status"); ?></th>
                            <th><?php echo trans("queue_worked_at"); ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($nebim_queues as $que): ?>
                            <tr>
                                <td><?=$que->id?></td>
                                <td>
                                    <?php if ($que->method == 'user_id'): ?>
                                      Kullanıcı
                                    <?php elseif ($que->method == 'order_id'): ?>
                                      Sipariş
                                    <?php else: echo $que->method; endif; ?>
                                </td>
                                <td class="text-left">
                                    <?php if ($que->method == 'user_id' && $user = get_user($que->user_id)): ?>
                                      <?php echo html_escape($user->username); ?>
                                      <br>
                                      <?php echo html_escape($user->email); ?>
                                    <?php endif; ?>
                                    <?php if ($que->method == 'order_id' && $order = get_order($que->order_id)): ?>
                                      <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($order->id); ?>" class="table-link">
                                        #<?php echo html_escape($order->order_number); ?>
                                      </a>
                                    <?php endif; ?>
                                </td>
                                <td><?=$que->attempt?></td>
                                <td>
                                    <?php
                                    /*
                                    * 1 => waiting
                                    * 2 => processing
                                    * 3 => complete
                                    * 4 => failed
                                    * 5 => pass
                                    */
                                    switch ($que->status) {
                                      case '2':
                                        $class = 'warning';
                                        $status = 'processing';
                                        break;
                                      case '3':
                                        $class = 'success';
                                        $status = 'complete';
                                        break;
                                      case '4':
                                        $class = 'danger';
                                        $status = 'failed';
                                        break;
                                      case '5':
                                        $status = 'pass';
                                        break;
                                      default:
                                        $class = 'warning';
                                        $status = 'waiting';
                                        break;
                                    } ?>
                                    <label class="label label-<?=$class ?? 'default'?>"><?=$status?></label>
                                </td>
                                <td><?php echo $que->worked_at ? formatted_date($que->worked_at):' - '; ?></td>
                                <td>
                                  <?php if ($que->status <= '2'): ?>
                                    <button class="btn btn-sm btn-success" type="button" onclick="runQueue('<?=$que->id?>')">
                                         Çalıştır
                										</button>
                                  <?php endif; ?>
                                  <button class="btn btn-sm bg-purple" type="button" data-toggle="modal" data-target="#detail_<?php echo $que->id; ?>">
                                      <?php echo trans('select_option'); ?>
              										</button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="detail_<?php echo $que->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                          <div class="modal-content modal-custom">
                                              <div class="modal-body" style="text-align:left !important">
                                                <h5><?php echo trans("log_response"); ?></h5>
                                                <?=d($que->response)?>
                                                <hr>
                                                <h5><?php echo trans("log_failed_msg"); ?></h5>
                                                <?=d($que->failed_msg)?>
                                              </div>
                                              <div class="modal-footer">
              						                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Kapat</button>
              						                    </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Modal -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (empty($nebim_queues)): ?>
                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  function runQueue(id) {
    swal({
        text: 'İşlem manuel çalıştıracaktır, devam edilsin mi?',
        icon: "warning",
        buttons: [mc20bt99_config.sweetalert_cancel, mc20bt99_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (confirm) {
        if (confirm) {
          swal({
              text: 'Lütfen bekleyiniz',
              icon: "warning",
              buttons: false
          });
          var url = '<?=base_url()?>queue/manuel/' + id;
          $.get(url, function(data, status){
            swal({
                text: data,
                icon: "info",
                buttons: false
            });
            setTimeout(function() {
              location.reload();
            }, 2100);
          });
        }
    });
  }
</script>
