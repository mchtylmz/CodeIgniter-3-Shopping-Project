<?php /* ?>
 <?php echo form_open('', ['method' => 'GET', 'id' => 'couponcode']); ?>
<div class="row d-flex align-items-end" style="margin-bottom: 10px">
	<div class="col-sm-12">
		<?php if ($this->session->flashdata('coupon_error')): ?>
				<div class="alert alert-danger bg-danger text-white p-2 text-left" role="alert">
					<?php echo $this->session->flashdata('coupon_error'); ?>
				</div>
		<?php
		$this->session->unset_userdata('coupon_error');
		endif; ?>
	</div>
	<!-- Kupon -->
	<div class="col-sm-8 form-group" style="margin-bottom:0px">
		<label><?=trans('coupon_code')?></label>
		<input name="coupon" class="form-control form-input" type="text" placeholder="<?=trans('coupon_code2')?>.." value="<?=input_get('coupon') ?? (session_coupon('coupon')->code ?? session_coupon('get'))?>" required>
	</div>
	<!-- Kupon -->
	<!-- submit -->
	<div class="col-sm-4">
		<button class="btn btn-md btn-custom btn-block" role="button" style="padding: 10px 2.5px; margin-top: 10px;margin-bottom:0px" type="submit"><?=trans('coupon_submit')?></button>
	</div>
	<!-- submit -->
</div>
<?php echo form_close(); ?>
<?php if ($coupon = session_coupon('coupon')): ?>
	<p style="margin-bottom: 4px;">
			<strong>
				<?=$coupon->code?> (<?=$coupon->message?>)
				<span class="float-right"><a href="?rm_coupon=<?=$coupon->code?>" style="color:red"><?=trans('coupon_remove')?></a></span>
			</strong>
	</p>
<?php endif; ?>
<?php */ ?>
<?php if (!empty($cart_total) && $cart_total->coupon_discount > 0): ?>
	<div class="row-custom m-b-15">
		<strong><?php echo trans("coupon"); ?>&nbsp;&nbsp;[<?= get_cart_discount_coupon(); ?>]&nbsp;&nbsp;<a href="javascript:void(0)" class="font-weight-normal" onclick="remove_cart_discount_coupon();">[<?= trans("remove"); ?>]</a><span class="float-right">-&nbsp;<?= price_decimal($cart_total->coupon_discount, $cart_total->currency); ?></span></strong>
	</div>
	<hr class="m-t-30 m-b-30">
<?php endif; ?>
<?php echo form_open('coupon-code-post', ['id' => 'form_validate', 'class' => 'm-0']); ?>
<label class="font-600"><?= trans("discount_coupon") ?></label>
<div class="cart-discount-coupon d-flex" style="display: flex">
	<input type="text" name="coupon_code" class="form-control form-input" value="<?= old(("coupon_code")); ?>" maxlength="254" placeholder="<?= trans("coupon_code") ?>" required>
	<button type="submit" class="btn btn-custom m-l-5"><?= trans("apply") ?></button>
</div>
<?php echo form_close(); ?>
<div class="cart-coupon-error">
	<?php if ($this->session->flashdata('error_coupon_code')): ?>
		<div class="text-danger">
			<?php echo $this->session->flashdata('error_coupon_code'); ?>
		</div>
	<?php endif; ?>
</div>
