<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style media="screen">
  td {vertical-align:middle !important;}
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= html_escape($title); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open($page_url, ['method' => 'GET']); ?>
                            <div class="item-table-filter">
                                <label><?php echo trans("payment_status"); ?></label>
                                <select name="payment_status" class="form-control custom-select">
                                    <option value="" selected><?php echo trans("all"); ?></option>
                                    <option value="payment_received" <?php echo ($this->input->get('payment_status', true) == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                                    <option value="awaiting_payment" <?php echo ($this->input->get('payment_status', true) == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
                                </select>
                            </div>

                            <div class="item-table-filter">
                                <label><?php echo trans("search"); ?></label>
                                <input name="q" class="form-control" placeholder="<?php echo trans("sale_id"); ?>" type="search" value="<?php echo str_slug(html_escape($this->input->get('q', true))); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>

                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="btn bg-purple btn-filter"><?php echo trans("filter"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                    <table class="table table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th scope="col"><?php echo trans("sale"); ?></th>
                            <?php if (active_nebimv3()): ?>
                              <th scope="col">Nebim</th>
                            <?php endif; ?>
                            <th scope="col"><?php echo trans("total"); ?></th>
                            <th scope="col"><?php echo trans("buyer"); ?></th>
                            <th scope="col"><?php echo trans("status"); ?></th>
                            <th scope="col"><?php echo trans("date"); ?></th>
                            <th scope="col"><?php echo trans("options"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($sales)): ?>
                            <?php foreach ($sales as $sale):
                                $total = $this->order_model->get_seller_total_price($sale->id);
                                if (!empty($sale)):?>
                                    <tr>
                                        <td>#<?php echo $sale->order_number; ?></td>
                                        <?php if (active_nebimv3()): ?>
                                        <td><?php echo $sale->nebim_order; ?></td>
                                        <?php endif; ?>
                                        <td><?php echo price_formatted($total, $sale->price_currency); ?></td>
                                        <td>
                        									<?php if ($sale->buyer_id == 0): ?>
                        										<div class="table-orders-user" style="display:flex; align-items:center">
                        											<img src="<?php echo get_user_avatar(null); ?>" alt="buyer" class="img-responsive" style="height: 40px;">
                        											<?php $shipping = get_order_shipping($item->id);
                        											if (!empty($shipping)): ?>
                        												<span><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?></span>
                        											<?php endif; ?>
                        											<label class="label bg-olive label-order-guest"><?php echo trans("guest"); ?></label>
                        										</div>
                        									<?php else:
                        										$buyer = get_user($sale->buyer_id);
                        										if (!empty($buyer)):?>
                        											<div class="table-orders-user" style="display:flex; align-items:center">
                                                <img src="<?php echo get_user_avatar($buyer); ?>" alt="buyer" class="img-responsive" style="height: 40px;">
                                                <?php echo html_escape($buyer->username); ?>
                        											</div>
                        										<?php endif;
                        									endif;
                        									?>
                        								</td>
                                        <td>
                                            <?php if ($sale->status == 1): ?>
                                              <label class="label label-success"><?= trans("completed"); ?></label>
                                            <?php elseif ($sale->status == 2): ?>
                                              <label class="label label-danger"><?= trans("cancelled"); ?></label>
                                            <?php else: ?>
                                              <label class="label label-default"><?= trans("order_processing"); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date("Y-m-d / h:i", strtotime($sale->created_at)); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateStatusModal_<?php echo $sale->id; ?>"><?php echo trans($sale->status == 0 ? 'update_status':'modal_order_products'); ?></button>

                                            <a href="<?= generate_dash_url("sale"); ?>/<?php echo $sale->order_number; ?>" class="btn btn-sm btn-default btn-details">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo trans("details"); ?></a>

                                            <div class="modal fade" id="updateStatusModal_<?php echo $sale->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                    <div class="modal-content modal-custom">
                                                      <?php if ($sale->status == 0): ?>
                                                        <!-- form start -->
                                                        <?php echo form_open('admin_controller/admin_update_order_status_post'); ?>
                                                        <input type="hidden" name="id" value="<?php echo $sale->id; ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo trans("update_status"); ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true"><i class="icon-close"></i> </span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <?php
                        																	if ($order_products = get_order_products($sale->id)): ?>
                        																		  <?php foreach ($order_products as $order_product): ?>
                                                                <div class="row" style="align-items:center; margin-bottom: 15px; display: flex; flex-wrap: wrap;">
                                                                  <div class="col-sm-2">
                                                                    <img style="width: 100%; object-fit:contain; margin-right: 5px; border:solid 1px #555" src="<?php echo get_product_image($order_product->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                                  </div>
                                                                  <div class="col-sm-10">
                                                                    <h5 class="list-group-item-heading"><?php echo html_escape($order_product->product_title); ?></h5>
                          																			    <p class="list-group-item-text">
                                                                      <?php if (active_nebimv3()): ?>
                                                                        <?php echo trans('barcode'); ?> : <?php echo $order_product->variation_option_barcodes; ?>
                                                                        <br>
                                                                      <?php endif; ?>
                          																						<?php echo trans('unit_price'); ?> : <?php echo price_formatted($order_product->product_unit_price, $order_product->product_currency); ?>
                          																						<br>
                          																						<?php echo trans('quantity'); ?> : <?php echo $order_product->product_quantity; ?>
                          																						<br>
                          																						<?php echo trans('total'); ?> : <?php echo price_formatted($sale->price_total, $sale->price_currency); ?>
                          																					</p>
                                                                  </div>
                                                                </div>
                        																		  <?php endforeach; ?>
                        																	<?php endif; ?>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo trans('status'); ?></label>
                                                                        <select id="select_order_status" name="status" class="form-control custom-select" data-order-id="<?php echo $sale->id; ?>">
                          																								<option value="" hidden><?php echo trans("status"); ?></option>
                                                                          <option value="awaiting_payment"><?php echo trans("awaiting_payment"); ?></option>
                                                                          <option value="payment_received"><?php echo trans("payment_received"); ?></option>
                                                                          <option value="order_processing"><?php echo trans("order_processing"); ?></option>
                                                                          <option value="shipped"><?php echo trans("shipped"); ?></option>
                                                                          <option value="completed"><?php echo trans("completed"); ?></option>
                                                                          <option value="cancelled"><?php echo trans("cancelled"); ?></option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="row tracking-number-container <?= $sale->status != '1' ? 'display-none' : ''; ?>">
                                                                        <hr>
                                                                        <div class="col-12 text-center">
                                                                            <strong><?= trans("shipping"); ?></strong>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label><?= trans("tracking_code"); ?></label>
                                                                                <input type="text" name="shipping_tracking_number" class="form-control form-input" value="" placeholder="<?= trans("tracking_code"); ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label><?= trans("tracking_url"); ?></label>
                                                                                <input type="text" name="shipping_tracking_url" class="form-control form-input" value="" placeholder="<?= trans("tracking_url"); ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                                                            <button type="submit" class="btn btn-md btn-success"><?php echo trans("submit"); ?></button>
                                                        </div>
                                                        <?php echo form_close(); ?><!-- form end -->
                                                      <?php else: ?>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo trans("modal_order_products"); ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true"><i class="icon-close"></i> </span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <?php
                        																	if ($order_products = get_order_products($sale->id)): ?>
                        																		  <?php foreach ($order_products as $order_product): ?>
                                                                <div class="row" style="align-items:center; margin-bottom: 15px; display: flex; flex-wrap: wrap;">
                                                                  <div class="col-sm-2">
                                                                    <img style="width: 100%; object-fit:contain; margin-right: 5px; border:solid 1px #555" src="<?php echo get_product_image($order_product->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                                  </div>
                                                                  <div class="col-sm-10">
                                                                    <h5 class="list-group-item-heading"><?php echo html_escape($order_product->product_title); ?></h5>
                          																			    <p class="list-group-item-text">
                                                                      <?php if (active_nebimv3()): ?>
                                                                        <?php echo trans('barcode'); ?> : <?php echo $order_product->variation_option_barcodes; ?>
                                                                        <br>
                                                                      <?php endif; ?>
                          																						<?php echo trans('unit_price'); ?> : <?php echo price_formatted($order_product->product_unit_price, $order_product->product_currency); ?>
                          																						<br>
                          																						<?php echo trans('quantity'); ?> : <?php echo $order_product->product_quantity; ?>
                          																						<br>
                          																						<?php echo trans('total'); ?> : <?php echo price_formatted($sale->price_total, $sale->price_currency); ?>
                          																					</p>
                                                                  </div>
                                                                </div>
                        																		  <?php endforeach; ?>
                        																	<?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                              <!-- modal -->
                                        </td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($sales)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($sales)): ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $num_rows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
