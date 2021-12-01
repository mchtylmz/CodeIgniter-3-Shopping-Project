<?php $clr =$this->general_settings->site_color;?>
<style>body {<?php echo $this->fonts->site_font_family; ?>}
<?php if(!empty($index_banners_array)):foreach ($index_banners_array as $banner_set):foreach ($banner_set as $banner):?>.index_bn_<?=$banner->id;?> {-ms-flex: 0 0 <?=$banner->banner_width;?>%;flex: 0 0 <?=$banner->banner_width;?>%;max-width: <?=$banner->banner_width;?>%;}  <?php endforeach; endforeach; endif; ?>
    a:active,a:focus,a:hover{color:<?= $clr; ?>}.btn-custom{background-color:<?= $clr; ?>;border-color:<?= $clr; ?>}.btn-block{background-color:<?= $clr; ?>}.btn-outline{border:1px solid <?= $clr; ?>;color:<?= $clr; ?>}.btn-outline:hover{background-color:<?= $clr; ?>!important}.btn-filter-products-mobile{border:1px solid <?= $clr; ?>;background-color:<?= $clr; ?>}.form-control:focus{border-color:<?= $clr; ?>}.link{color:<?= $clr; ?>!important}.link-color{color:<?= $clr; ?>}.top-search-bar .btn-search{background-color:<?= $clr; ?>}.nav-top .nav-top-right .nav li a:active,.nav-top .nav-top-right .nav li a:focus,.nav-top .nav-top-right .nav li a:hover{color:<?= $clr; ?>}.nav-top .nav-top-right .nav li .btn-sell-now{background-color:<?= $clr; ?>!important}.nav-main .navbar>.navbar-nav>.nav-item:hover .nav-link:before{background-color:<?= $clr; ?>}.li-favorites a i{color:<?= $clr; ?>}.product-share ul li a:hover{color:<?= $clr; ?>}.pricing-card:after{background-color:<?= $clr; ?>}.selected-card{-webkit-box-shadow:0 3px 0 0 <?= $clr; ?>;box-shadow:0 3px 0 0 <?= $clr; ?>}.selected-card .btn-pricing-button{background-color:<?= $clr; ?>}.profile-buttons .social ul li a:hover{background-color:<?= $clr; ?>;border-color:<?= $clr; ?>}.btn-product-promote{background-color:<?= $clr; ?>}.contact-social ul li a:hover{background-color:<?= $clr; ?>;border-color:<?= $clr; ?>}.price-slider .ui-slider-horizontal .ui-slider-handle{background:<?= $clr; ?>}.price-slider .ui-slider-range{background:<?= $clr; ?>}.p-social-media a:hover{color:<?= $clr; ?>}.blog-content .blog-categories .active a{background-color:<?= $clr; ?>}.nav-payout-accounts .active,.nav-payout-accounts .show>.nav-link{background-color:<?= $clr; ?>!important}.pagination .active a{border:1px solid <?= $clr; ?>!important;background-color:<?= $clr; ?>!important}.pagination li a:active,.pagination li a:focus,.pagination li a:hover{background-color:<?= $clr; ?>;border:1px solid <?= $clr; ?>}.spinner>div{background-color:<?= $clr; ?>}::selection{background:<?= $clr; ?>!important}::-moz-selection{background:<?= $clr; ?>!important}.cookies-warning a{color:<?= $clr; ?>}.custom-checkbox .custom-control-input:checked~.custom-control-label::before{background-color:<?= $clr; ?>}.custom-control-input:checked~.custom-control-label::before{border-color:<?= $clr; ?>;background-color:<?= $clr; ?>}.custom-control-variation .custom-control-input:checked~.custom-control-label{border-color:<?= $clr; ?>!important;}.btn-wishlist .icon-heart{color:<?= $clr; ?>}.product-item-options .item-option .icon-heart{color:<?= $clr; ?>}.mobile-language-options li .selected,.mobile-language-options li a:hover{color:<?= $clr; ?>;border:1px solid <?= $clr; ?>}.mega-menu .link-view-all, .link-add-new-shipping-option{color:<?= $clr; ?>!important;}.mega-menu .menu-subcategories ul li .link-view-all:hover{border-color:<?= $clr; ?>!important}.custom-select:focus{border-color:<?= $clr; ?>}</style>
<script>var mc20bt99_config = {base_url: "<?= base_url(); ?>", lang_base_url: "<?= lang_base_url(); ?>", sys_lang_id: "<?= $this->selected_lang->id; ?>", thousands_separator: "<?= $this->thousands_separator; ?>", csfr_token_name: "<?= $this->security->get_csrf_token_name(); ?>", csfr_cookie_name: "<?= $this->config->item('csrf_cookie_name'); ?>", txt_all: "<?= trans("all"); ?>", txt_no_results_found: "<?= trans("no_results_found"); ?>", sweetalert_ok: "<?= trans("ok"); ?>", sweetalert_cancel: "<?= trans("cancel"); ?>", msg_accept_terms: "<?= trans("msg_accept_terms"); ?>", cart_route: "<?= !empty($this->routes) && !empty($this->routes->cart) ? $this->routes->cart : ''; ?>", slider_fade_effect: "<?= ($this->general_settings->slider_effect == "fade") ? 1 : 0; ?>", is_recaptcha_enabled: "<?= !empty($recaptcha_status) && $recaptcha_status == true ? "true" : "false" ?>", rtl: <?= $this->rtl == "true" ? true : "false" ?>, txt_add_to_cart: "<?= trans("add_to_cart"); ?>", txt_added_to_cart: "<?= trans("added_to_cart"); ?>", txt_add_to_wishlist: "<?= trans("add_to_wishlist"); ?>", txt_remove_from_wishlist: "<?= trans("remove_from_wishlist"); ?>"};if(mc20bt99_config.rtl==1){mc20bt99_config.rtl=true;}</script>

<style media="screen">
  .storiesWrapper {
    padding: 18px 16px 16px 16px;
    max-width: 1108px;
    margin: 0 auto;
    text-align: center;
  }
  #zuck-modal-content .story-viewer .head .back, #zuck-modal-content .story-viewer .head .right .close {
    color: #fff !important;
  }
  .stories.carousel .story>.item-link>.info,
  #zuck-modal-content .story-viewer .head .time {
    display: none !important;
  }
  #zuck-modal-content .story-viewer .slides .item.active,
  #zuck-modal-content .story-viewer .slides .item.active .tip.link {
    color: #FFF !important;
  }
  .storeWrapper h1 {
	 text-align: center;
	 font-family: monospace;
	 padding: 0 12px;
	 border-bottom: 1px solid #ddd;
	 font-size: 24px;
	 height: 56px;
	 line-height: 56px;
	 margin-bottom: 0;
	 white-space: nowrap;
	 text-overflow: ellipsis;
	 overflow: hidden;
}
 .storeWrapper h1.Snapgram {
	 background: #fff;
	 color: #333;
}
 .storeWrapper .disclaimer {
	 display: block;
	 text-decoration: none !important;
	 color: #333;
	 line-height: 1.5em;
	 background: #ffffd2;
	 border-radius: 3px;
	 margin: 12px 12px 0;
	 padding: 12px 12px 12px 74px;
	 font-size: 13px;
	 max-width: 500px;
	 overflow: hidden;
	 min-height: 50px;
}
 .storeWrapper .disclaimer img {
	 float: left;
	 margin-right: 12px;
	 width: 50px;
	 position: absolute;
	 margin-left: -62px;
}
 .storeWrapper .disclaimer a {
	 color: inherit !important;
	 border: 0;
}
 .storeWrapper .disclaimer p {
	 margin: 0;
}
 .storeWrapper .disclaimer p + p {
	 margin-top: 1.25em;
}
 .storeWrapper .skin {
	 text-transform: uppercase;
	 white-space: nowrap;
	 overflow: hidden;
	 font-weight: bold;
	 position: absolute;
	 z-index: 10;
	 left: 0;
	 right: 0;
	 bottom: 0;
	 background: #fff;
	 font-size: 16px;
	 padding: 12px;
	 color: #fff;
	 background: #333;
}
 .storeWrapper .skin select {
	 background: #fff;
	 font-size: inherit;
	 text-transform: none;
	 max-width: 30%;
}
 @media (min-width: 540px) {
	 .storeWrapper .disclaimer {
		 margin: 12px auto;
	}
}
  .nav-top .nav-top-left .logo a img {
    max-width: 150px;
    width: inherit;
  }
  .product-item .img-product,
  .img-product-container,
  .col-content-products .product-item .img-product,
  .col-content-products .img-product-container {
    height: 300px
  }
  .index-mobile-slider .slider-container, .index-mobile-slider .item {
    height: 580px !important;
  }
  .login-modal {
    max-width: 400px;
  }
  .new-profile .notification {
    position: absolute;
    right: 5px;
    top: 0;
    font-size: 12px;
    background-color: #f15e4f;
    width: 18px;
    border-radius: 50%;
    display: block;
    height: 18px;
    line-height: 18px;
    text-align: center;
    color: #fff;
    font-weight: 600;
  }
  .span-message-count {
    font-size: 12px;
    background-color: #f15e4f;
    width: 18px;
    border-radius: 50%;
    height: 18px;
    line-height: 18px;
    text-align: center;
    color: #fff;
    font-weight: 600;
    padding: 0px 4px;
  }
  .nav-item-language .info {
    position: absolute;
    right: 5px;
    top: 0px;
    font-size: 14px;
    background-color: #eee;
    width: 18px;
    border-radius: 50%;
    display: block;
    height: 18px;
    line-height: 18px;
    text-align: center;
    color: #000;
    font-weight: 600;
  }
  .lb {width: 12.5px; height: 12.5px;}
  .lb .cb {border-radius: 50%;border:solid 1px #eee;}
  .lb.custom-control-label::before, .lb.custom-control-label::after {display: none;}
  .custom-control-variation .option-out-of-stock {
    background: linear-gradient(to left top, transparent 47.75%, red 49.5%, red 50.5%, transparent 52.25%);
    text-decoration: unset;
  }
  .index-products-slider-nav .prev, .index-products-slider-nav .next, .main-slider-nav {
    opacity: 0.8;
  }
  .slick-dots {
    display: flex;
    justify-content: center;
    margin: 0;
    padding: 0 0 1rem 0;
    list-style-type: none;
  }
  .slick-dots li {
    margin: 0 0.25rem;
  }
  .slick-dots button {
    display: block;
    width: 0.75rem;
    height: 0.75rem;
    padding: 0;
    border: none;
    border-radius: 100%;
    background-color: rgba(0,0,0,0.4);
    text-indent: -9999px;
    margin: 0px 3px;
  }
  .slick-dots li.slick-active button {
    background-color: rgba(0,0,0,0.8);
  }
  .mobile-show, .tr-mobile-show {
    display: none;
  }
  @media only screen and (max-width: 768px) {
    .mobile-show {
      display: block;
    }
    .tr-mobile-show {
      display: table-row;
    }
    .mobile-hidden {
      display: none;
    }
    .product-item .img-product,
    .img-product-container,
    .col-content-products .product-item .img-product,
    .col-content-products .img-product-container {
      height: 240px;
      object-fit: contain;
    }
  }
  .custom-control-variation .custom-control-label {
    min-width: 20px;
    min-height: 20px;
    line-height: 17.5px;
    border-radius: 12px;
  }
  .variation-color-box {
    border-radius: 50%;
  }
  .badge-discount.promoted {
    top: 30px !important;
  }
  .li-main-nav-right a i {
    margin-right: 0 !important;
    font-size: 1.65rem;
  }
  .icon-user {
    font-size: 1.55rem;
  }
  .nav-item-language .info::after, .dropdown-toggle::after {
    display: none !important;
  }
  .new-profile {
    padding-left: 2px !important;
  }
  .modal-send-message .user-contact-modal img {
    width: 54px;
    height: 54px;
  }
  .btn-product-cart {
    padding-top: 0.65rem !important;
  }
</style>
