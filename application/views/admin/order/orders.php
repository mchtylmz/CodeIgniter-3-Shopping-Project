<?php  ?>

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $title; ?></h3>
	</div><!-- /.box-header -->

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
					<table class="table table-bordered table-striped" role="grid">
						<?php $this->load->view('admin/order/_filter_orders'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('order'); ?></th>
							<?php if (active_nebimv3()): ?>
								<th>Nebim</th>
							<?php endif; ?>
							<th><?php echo trans('products'); ?></th>
							<th><?php echo trans('buyer'); ?></th>
							<th><?php echo trans('total'); ?></th>
							<th><?php echo trans('payment_method'); ?></th>
							<th><?php echo trans('status'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($orders as $item): ?>
							<tr>
								<td class="order-number-table">
									<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="table-link">
										#<?php echo html_escape($item->order_number); ?>
									</a>
								</td>
								<?php if (active_nebimv3()): ?>
									<td class="order-number-table">
										<span><?php echo html_escape($item->nebim_order); ?></span>
									</td>
								<?php endif; ?>
								<td style="min-width: 60px; max-width: 180px;">
								<?php if ($order_products = get_order_products($item->id)): ?>
										<div class="d-flex" style="display:flex; align-items:center; flex-wrap: wrap;">
											<?php foreach ($order_products as $order_product): ?>
												<a href="<?php echo admin_url(); ?>product-details/<?=$order_product->product_id?>" target="_blank" data-toggle="tooltip" data-placement="top" title="<?=$order_product->product_title?>, <?=$order_product->variation_option_barcodes ?? ''?>">
														<img style="height:48px; object-fit:contain; margin: 2px 5px; border:solid 1px #555" src="<?php echo get_product_image($order_product->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
												</a>
											<?php endforeach; ?>
										</div>
								<?php endif; ?>
								</td>
								<td>
									<?php if ($item->buyer_id == 0): ?>
										<div class="table-orders-user">
											<img src="<?php echo get_user_avatar(null); ?>" alt="buyer" class="img-responsive" style="height: 40px;">
											<?php $shipping = get_order_shipping($item->id);
											if (!empty($shipping)): ?>
												<span><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?></span>
											<?php endif; ?>
											<label class="label bg-olive label-order-guest"><?php echo trans("guest"); ?></label>
										</div>
									<?php else:
										$buyer = get_user($item->buyer_id);
										if (!empty($buyer)):?>
											<div class="table-orders-user">
												<?php echo html_escape($buyer->username); ?>
												<br>
												<?php echo html_escape($buyer->email); ?>
											</div>
										<?php endif;
									endif;
									?>
								</td>
								<td><strong><?php echo price_formatted($item->price_total, $item->price_currency); ?></strong></td>
								<td><?= get_payment_method($item->payment_method); ?></td>
								<td>
									<?php if ($item->status == 1): ?>
										<label class="label label-success"><?php echo trans("completed"); ?></label>
									<?php elseif ($item->status == 2): ?>
										<label class="label label-danger"><?php echo trans("cancelled"); ?></label>
									<?php else: ?>
										<label class="label label-default"><?php echo trans("order_processing"); ?></label>
									<?php endif; ?>
								</td>
								<td>
									<?=trans('updated')?>: <?php echo time_ago($item->updated_at); ?>
									<br>
									<?php echo formatted_date($item->created_at); ?>
								</td>
								<td>
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown" style="min-width: 190px;">
											<li>
													<a href="#" data-toggle="modal" data-target="#updateStatusModal_<?php echo $item->id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('update_status'); ?></a>
											</li>
											<li>
												<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans('view_details'); ?></a>
											</li>
											<li>
												<?php if ($item->payment_status != 'payment_received'): ?>
													<?php echo form_open_multipart('order_admin_controller/order_options_post'); ?>
													<input type="hidden" name="id" value="<?php echo $item->id; ?>">
													<button type="submit" name="option" value="payment_received" class="btn-list-button">
														<i class="fa fa-check option-icon"></i><?php echo trans('payment_received'); ?>
													</button>
													<?php echo form_close(); ?><!-- form end -->
												<?php endif; ?>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_order_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>

										<!-- Modal -->
										<div class="modal fade" id="updateStatusModal_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
						            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
						                <div class="modal-content modal-custom">
															<?php echo form_open('admin_controller/admin_update_order_status_post', ['id' => 'update_order_status']); ?>
															<input type="hidden" name="id" value="<?php echo $item->id; ?>">
															<div class="modal-header">
																	<h5 class="modal-title"><?php echo trans("update_status"); ?></h5>
																	<button type="button" class="close" data-dismiss="modal">
																			<span aria-hidden="true"><i class="icon-close"></i> </span>
																	</button>
															</div>
															<div class="modal-body">
																	<?php if ($order_products): ?>
																	<div style="max-height: 540px; overflow-x: hidden; border: solid 1px #eee;">
																			<?php foreach ($order_products as $order_product): ?>
																				<div class="row" style="align-items:center; margin-bottom: 15px; display: flex; flex-wrap: wrap;">
																					<div class="col-sm-3">
																						<img style="width: 100%; object-fit:contain; margin-right: 5px; border:solid 1px #555" src="<?php echo get_product_image($order_product->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
																					</div>
																					<div class="col-sm-9">
																						<h5 class="list-group-item-heading"><b><?php echo html_escape($order_product->product_title); ?></b></h5>
																						<p class="list-group-item-text">
																							<?php if (active_nebimv3()): ?>
																								<?php echo trans('barcode'); ?> : <?php echo $order_product->variation_option_barcodes; ?>
																								<br>
																							<?php endif; ?>
																							<?php echo trans('sku'); ?> : <?php echo $order_product->product_sku; ?>
																							<br>
																							<?php echo trans('unit_price'); ?> : <?php echo price_formatted($order_product->product_unit_price, $order_product->product_currency); ?>
																							<br>
																							<?php echo trans('quantity'); ?> : <?php echo $order_product->product_quantity; ?>
																							<br>
																							<?php echo trans('total'); ?> : <?php echo price_formatted($order_product->product_total_price, $item->price_currency); ?>
																						</p>
																					</div>
																				</div>
																			<?php endforeach; ?>
																			</div>
																			<br>
																	<?php endif; ?>
																	<div class="row">
																			<div class="col-sm-12">
																					<div class="form-group">
																							<label class="control-label"><?php echo trans('status'); ?></label>
																							<select id="select_order_status" name="order_status" class="form-control custom-select" data-order-id="<?php echo $item->id; ?>">
																								<option value="" hidden><?php echo trans("status"); ?></option>
																								<?php if ($item->status == 0): ?>
																								<option value="awaiting_payment"><?php echo trans("awaiting_payment"); ?></option>
																								<option value="payment_received"><?php echo trans("payment_received"); ?></option>
																								<option value="order_processing"><?php echo trans("order_processing"); ?></option>
																								<option value="shipped"><?php echo trans("shipped"); ?></option>
																								<?php endif; ?>
																								<?php if ($item->status != 1): ?>
																								<option value="completed"><?php echo trans("completed"); ?></option>
																								<?php endif; ?>
																								<?php if ($item->status != 2): ?>
																								<option value="cancelled"><?php echo trans("cancelled"); ?></option>
																								<?php endif; ?>
																							</select>
																					</div>
																					<div class="row tracking-number-container <?= $item->status != '1' ? 'display-none' : ''; ?>">
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
						                </div>
						            </div>
						        </div>
								    <!-- Modal -->

									</div>
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($orders)): ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-12 table-ft">
						<div class="row">
							<div class="pull-right">
								<?php echo $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
</div>
<script>
    $(document).on("change", "#select_order_status", function () {
        var val = $(this).val();
        if (val == "shipped") {
            $(".tracking-number-container").show();
        } else {
            $(".tracking-number-container").hide();
        }
    });
</script>
<script type="text/javascript">
  $('form#update_order_status').submit(function(event) {
    $(this).find('button[type=submit]').attr('disabled', 'disabled').text('<?=trans('please_wait')?>');
  });
</script>
