<?php  ?>
<style media="screen">
  tr,th,td {
    text-align: center !important;
    vertical-align: middle !important;
  }
  .m-3 {margin: 10px 0}
  .print.collapse {max-height: 540px; overflow-y:scroll; border: solid 2px #eee}
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo $title; ?></h3>
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
                              <div class="item-table-filter" style="min-width: 120px;">
                                  <label><?php echo trans("status"); ?></label>
                                  <select name="status" class="form-control">
                                      <option value=""><?=trans('all')?></option>
                                      <option value="1" <?php echo ($this->input->get('status', true) == '1') ? 'selected' : ''; ?>><?=trans('succeeded')?></option>
                                      <option value="2" <?php echo ($this->input->get('status', true) == '2') ? 'selected' : ''; ?>><?=trans('failed')?></option>
                                  </select>
                              </div>

                              <div class="item-table-filter" style="min-width: 120px;">
                                  <label>Provizyon</label>
                                  <input name="bank_code" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('bank_code', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter" style="min-width: 120px;">
                                  <label><?php echo trans("reference_no"); ?></label>
                                  <input name="reference_no" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('reference_no', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter" style="min-width: 120px;">
                                  <label><?php echo trans("ip_address"); ?></label>
                                  <input name="ip_address" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('ip_address', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                  <label style="display: block">&nbsp;</label>
                                  <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
                              </div>
                              <?php echo form_close(); ?>
                          </div>
                      </div>
                        <thead>
                        <tr role="row">
                            <th width="20">Provizyon</th>
                            <th><?=trans('order')?></th>
                            <th><?=trans('status')?></th>
                            <th><?=trans('response_code')?></th>
                            <th><?=trans('ip_address')?></th>
                            <th><?=trans('date')?></th>
                            <th><?=trans('options')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($paynet_pos as $pos): ?>
                            <tr>
                                <td><?=$pos->bank_code ? $pos->bank_code:'0'?></td>
                                <td>
                                  <?php if ($pos->is_succeed): ?>
                                    <label class="label label-primary text-md">
                                      <a style="color:white" href="<?=admin_url()?>orders?order=<?=$pos->order_id?>"><?=trans('order')?></a>
                                    </label>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if ($pos->is_succeed): ?>
                                    <label class="label label-success"><?=trans('succeeded')?></label>
                                  <?php else: ?>
                                    <label class="label label-danger"><?=trans('failed')?></label>
                                  <?php endif; ?>
                                </td>
                                <td>0<?=$pos->response_code?> / <?=$pos->reference_no?></td>
                                <td><?=$pos->ip_address?></td>
                                <td><?php echo formatted_date($pos->created_at); ?></td>
                                <td>
                                  <button class="btn btn-sm bg-purple" type="button" data-toggle="modal" data-target="#detail<?=$pos->id?>">
                                      <?=trans('payment_details')?>
              										</button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="detail<?=$pos->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                          <div class="modal-content modal-custom">
                                              <div class="modal-body" style="text-align:left !important">
                                                
                                                <h3>Data</h3>
                                                <?=d($pos->data)?>
                                                <hr>
                                                <h3>Response</h3>
                                                <?=d($pos->response)?>
                                                <hr>
                                                <h3>SESSION</h3>
                                                <?=d($pos->session)?>

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
                    <?php if (empty($paynet_pos)): ?>
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
