<?php  ?>
<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php $this->load->view("partials/_user_profile_menu", ['active' => 'orders']); ?>
			</div>

			<div class="col-12">
				<nav class="nav-breadcrumb" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
					</ol>
				</nav>
				<h1 class="page-title"><?php echo $title; ?></h1>
			</div>
		</div>

		<div class="row">

			<!--
			<div class="col-sm-12 col-md-3">
				<div class="row-custom">
					<?php $this->load->view("order/_order_tabs"); ?>
				</div>
			</div>
			-->

			<div class="col-sm-12 col-md-12">
				<div class="row-custom">
					<div class="profile-tab-content">
						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th scope="col"><?php echo trans("order"); ?></th>
									<th scope="col"><?php echo trans("total"); ?></th>
									<th scope="col" class="mobile-hidden"><?php echo trans("payment"); ?></th>
									<th scope="col"><?php echo trans("status"); ?></th>
									<th scope="col" class="mobile-hidden"><?php echo trans("date"); ?></th>
									<th scope="col" class="mobile-hidden"><?php echo trans("options"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($orders)): ?>
									<?php foreach ($orders as $order): ?>
										<tr>
											<td>#<?php echo $order->order_number; ?></td>
											<td><?php echo price_formatted($order->price_total, $order->price_currency); ?></td>
											<td class="mobile-hidden">
												<?php if ($order->payment_status == 'payment_received'):
													echo trans("payment_received");
												else:
													echo trans("awaiting_payment");
												endif; ?>
											</td>
											<td>
												<strong class="font-600">
													<?php if ($order->payment_status == 'awaiting_payment'):
														if ($order->payment_method == 'Cash On Delivery') {
															echo trans("order_processing");
														} else {
															echo trans("awaiting_payment");
														}
													else:
														if ($order->status == 1):
															echo '<label class="label text-success">'.trans("completed").'</label>';
														elseif ($order->status == 2):
															echo '<label class="label text-danger">'.trans("cancelled").'</label>';
														else:
															echo '<label class="label text-default">'.trans("order_processing").'</label>';
														endif;
													endif; ?>
												</strong>
											</td>
											<td class="mobile-hidden"><?php echo formatted_date($order->created_at); ?></td>
											<td class="mobile-hidden">
												<a href="<?php echo generate_url("order_details") . "/" . $order->order_number; ?>" class="btn btn-sm btn-table-info"><?php echo trans("details"); ?></a>
											</td>
										</tr>
										<tr class="tr-mobile-show">
											<td colspan="2">
												<?php echo formatted_date($order->created_at); ?>
											</td>
											<td colspan="1">
												<a href="<?php echo generate_url("order_details") . "/" . $order->order_number; ?>" class="btn btn-sm btn-table-info"><?php echo trans("details"); ?></a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>


						<?php if (empty($orders)): ?>
							<p class="text-center">
								<?php echo trans("no_records_found"); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
				<div class="row-custom m-t-15">
					<div class="float-right">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Wrapper End-->
