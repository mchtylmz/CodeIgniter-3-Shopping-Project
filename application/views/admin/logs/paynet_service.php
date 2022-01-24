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
                        <?php /*foreach ($paynet_pos as $pos): ?>
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
                        <?php endforeach; */?>
                        </tbody>
                    </table>
                    <?php if (empty($paynet_services)): ?>
                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
                <?php d($results); ?>
            </div>
        </div>
    </div>
</div>
