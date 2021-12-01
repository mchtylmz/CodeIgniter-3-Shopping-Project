<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box box-primary">
  <div class="box-header">
    <h3 style="font-size: 18px; font-weight: 600; margin-top:0;"><?php echo trans('lastest_10_notifications'); ?></h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
            <thead>
            <tr role="row">
                <th style="max-width: 440px"><?php echo trans('contents'); ?></th>
                <th><?php echo trans('received_converted'); ?></th>
                <th><?php echo trans('successful'); ?></th>
                <th><?php echo trans('failed'); ?></th>
                <th><?php echo trans('send_after'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($notifications['notifications']) && $notifications['notifications']): ?>
              <?php foreach ($notifications['notifications'] as $key => $row): ?>
                <tr>
                    <td style="max-width: 440px">
                      <?php foreach ($row['contents'] as $lang => $message): ?>
                        <div class="mt-1 mb-2"><?=$message?></div>
                      <?php endforeach; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo intval($row['successful'] + $row['failed']) .' / '. $row['converted']; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $row['successful']; ?>
                    </td>
                    <td style="text-align:center">
                      <?php echo $row['failed']; ?>
                    </td>
                    <td>
                      <span><?=date('d/m/Y H:i', $row['send_after'])?></span>
                    </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
    <div class="col-sm-12 text-right">
        <?=trans('total')?>: <?=$notifications['total_count'] ?? 0?>
    </div>
  </div><!-- /.box-body -->
</div>
