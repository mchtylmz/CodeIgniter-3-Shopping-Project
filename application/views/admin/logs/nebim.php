<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style media="screen">
  tr,th,td {
    text-align: center !important;
  }
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans("nebim_logs"); ?></h3>
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

                              <div class="item-table-filter">
                                  <label><?php echo trans("log_procedure"); ?></label>
                                  <input name="name" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('name', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter" style="width: 120px; min-width: 120px;">
                                  <label><?php echo trans("status"); ?></label>
                                  <select name="status" class="form-control">
                                      <option value="">Tümü</option>
                                      <option value="1" <?php echo ($this->input->get('status', true) == '1') ? 'selected' : ''; ?>>Başarılı</option>
                                      <option value="2" <?php echo ($this->input->get('status', true) == '2') ? 'selected' : ''; ?>>Başarısız</option>
                                  </select>
                              </div>

                              <div class="item-table-filter">
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
                            <th><?php echo trans("log_procedure"); ?></th>
                            <th><?php echo trans("log_data"); ?></th>
                            <th><?php echo trans("log_response"); ?></th>
                            <th><?php echo trans("update"); ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($nebim_logs as $log): ?>
                            <tr>
                                <td>
                                  <?=$log->import?>
                                </td>
                                <td>
                                    <?=$log->name?>
                                </td>
                                <td>
                                  <?php if ($log->data): ?>
                                      <?php if (strpos($log->data, "Exception") !== false || strpos($log->data,"error") !== false): ?>
                                        <label class="label label-danger"><i class="fa fa-times"></i></label>
                                      <?php else: ?>
                                        <label class="label label-success"><i class="fa fa-check"></i></label>
                                      <?php endif; ?>
                                  <?php else: ?>
                                      <label class="label label-warning"><i class="fa fa-square"></i></label>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if ($log->response): ?>
                                    <?php if (strpos($log->response, "Exception") !== false || strpos($log->response,"error") !== false): ?>
                                      <label class="label label-danger"><i class="fa fa-times"></i></label>
                                    <?php else: ?>
                                      <label class="label label-success"><i class="fa fa-check"></i></label>
                                    <?php endif; ?>
                                  <?php else: ?>
                                      <label class="label label-warning"><i class="fa fa-square"></i></label>
                                  <?php endif; ?>
                                </td>
                                <td><?php echo formatted_date($log->created_at); ?></td>
                                <td>
                                  <button class="btn btn-sm bg-purple" type="button" data-toggle="modal" data-target="#detail<?=$log->id?>">
                                      <?=trans('queue_detail')?>
              										</button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="detail<?=$log->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                          <div class="modal-content modal-custom">
                                              <div class="modal-body" style="text-align:left !important">
                                                <?=d($log->data)?>
                                                <br>
                                                <?=d($log->response)?>
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
                    <?php if (empty($nebim_logs)): ?>
                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6 text-left">
                <h4><?=trans('total')?>: <?php echo $total ?? 0; ?> </h4>
            </div>
            <div class="col-sm-6 text-right">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
