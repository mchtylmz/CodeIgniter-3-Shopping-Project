<style>
	.account-menu .selected {
		background-color: #f8f9fa !important;
	}
</style>
<?php $active = $active ?? ''; ?>
<div class="row mb-3 align-items-center justify-content-center container p-0 ml-1">

	<div class="col-sm-4 col-md-3 col-lg-2 col-6 list-group account-menu">
		<a href="<?php echo generate_url("settings", "update_profile"); ?>" class="list-group-item list-group-item-action border d-flex align-items-center <?=$active == 'profile' ? 'selected':''?>">
			<i class="icon-user mr-2" style="font-size: 1rem"></i> <?php echo trans("my_account"); ?>
		</a>
	</div>

	<div class="col-sm-4 col-md-3 col-lg-2 col-6 list-group account-menu">
		<a href="<?php echo generate_url("orders"); ?>" class="list-group-item list-group-item-action border d-flex align-items-center <?=$active == 'orders' ? 'selected':''?>">
			<i class="icon-shopping-basket mr-2" style="font-size: 1rem"></i> <?php echo trans("orders"); ?>
		</a>
	</div>

	<div class="col-sm-4 col-md-3 col-lg-2 col-6 list-group account-menu">
		<a href="<?php echo generate_url("messages"); ?>" class="list-group-item list-group-item-action border d-flex align-items-center <?=$active == 'messages' ? 'selected':''?>">
			<i class="icon-mail mr-2" style="font-size: 1rem"></i> <?php echo trans("messages"); ?>
		</a>
	</div>

	<div class="col-sm-4 col-md-3 col-lg-2 col-6 list-group account-menu">
		<a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>" class="list-group-item list-group-item-action border d-flex align-items-center <?=$active == 'wishlist' ? 'selected':''?>">
			<i class="icon-heart-o mr-2" style="font-size: 1rem"></i> <?php echo trans("wishlist"); ?>
		</a>
	</div>

</div>
