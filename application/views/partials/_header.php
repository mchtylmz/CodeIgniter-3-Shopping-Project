<?php  ?>
<!DOCTYPE html>
<html lang="<?= $this->selected_lang->short_form ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= xss_clean($title); ?> - <?= xss_clean($this->settings->site_title); ?></title>
    <meta name="description" content="<?= xss_clean($description); ?>"/>
    <meta name="keywords" content="<?= xss_clean($keywords); ?>"/>
    <meta name="author" content="<?= xss_clean($this->general_settings->application_name); ?>"/>
    <link rel="shortcut icon" type="image/png" href="<?= get_favicon($this->general_settings); ?>"/>
    <meta property="og:locale" content="tr-TR"/>
    <meta property="og:site_name" content="<?= xss_clean($this->general_settings->application_name); ?>"/>
<?php if (isset($show_og_tags)): ?>
    <meta property="og:type" content="<?= !empty($og_type) ? $og_type : 'website'; ?>"/>
    <meta property="og:title" content="<?= !empty($og_title) ? $og_title : 'index'; ?>"/>
    <meta property="og:description" content="<?= $og_description; ?>"/>
    <meta property="og:url" content="<?= $og_url; ?>"/>
    <meta property="og:image" content="<?= $og_image; ?>"/>
    <meta property="og:image:width" content="<?= !empty($og_width) ? $og_width : 250; ?>"/>
    <meta property="og:image:height" content="<?= !empty($og_height) ? $og_height : 250; ?>"/>
    <meta property="article:author" content="<?= !empty($og_author) ? $og_author : ''; ?>"/>
    <meta property="fb:app_id" content="<?= $this->general_settings->facebook_app_id; ?>"/>
<?php if (!empty($og_tags)):foreach ($og_tags as $tag): ?>
    <meta property="article:tag" content="<?= $tag->tag; ?>"/>
<?php endforeach; endif; ?>
    <meta property="article:published_time" content="<?= !empty($og_published_time) ? $og_published_time : ''; ?>"/>
    <meta property="article:modified_time" content="<?= !empty($og_modified_time) ? $og_modified_time : ''; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?= xss_clean($this->general_settings->application_name); ?>"/>
    <meta name="twitter:creator" content="@<?= xss_clean($og_creator); ?>"/>
    <meta name="twitter:title" content="<?= xss_clean($og_title); ?>"/>
    <meta name="twitter:description" content="<?= xss_clean($og_description); ?>"/>
    <meta name="twitter:image" content="<?= $og_image; ?>"/>
    <?php else: ?>
    <meta property="og:image" content="<?= get_logo($this->general_settings); ?>"/>
    <meta property="og:image:width" content="160"/>
    <meta property="og:image:height" content="60"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= xss_clean($title); ?> - <?= xss_clean($this->settings->site_title); ?>"/>
    <meta property="og:description" content="<?= xss_clean($description); ?>"/>
    <meta property="og:url" content="<?= base_url(); ?>"/>
    <meta property="fb:app_id" content="<?= $this->general_settings->facebook_app_id; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?= xss_clean($this->general_settings->application_name); ?>"/>
    <meta name="twitter:title" content="<?= xss_clean($title); ?> - <?= xss_clean($this->settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?= xss_clean($description); ?>"/>
<?php endif; ?>
<?php if ($this->general_settings->pwa_status == 1): ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="<?= xss_clean($this->general_settings->application_name); ?>">
    <meta name="msapplication-TileImage" content="<?= base_url(); ?>assets/img/pwa/144x144.png">
    <meta name="msapplication-TileColor" content="#2F3BA2">
    <link rel="manifest" href="<?= base_url(); ?>manifest.json">
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/pwa/144x144.png">
<?php endif; ?><link rel="canonical" href="<?= current_full_url(); ?>"/>
<?php if ($this->general_settings->multilingual_system == 1):
foreach ($this->languages as $language): ?>
    <link rel="alternate" href="<?= convert_url_by_language($language); ?>" hreflang="<?= $language->language_code ?>"/>
<?php endforeach; endif; ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/font-icons/css/mds-icons.min.css"/>
    <?= !empty($this->fonts->site_font_url) ? $this->fonts->site_font_url : ''; ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style-1.9.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/plugins-1.9.css"/>
<?php if ($this->rtl == true): ?>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/rtl-1.9.min.css">
<?php endif; ?>
<?php if (active_story()): ?>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/story/dist/zuck.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/story/dist/skins/snapgram.min.css">
<?php endif; ?>
<?php $this->load->view("partials/_css_js_header"); ?>
<?= $this->general_settings->google_analytics; ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-G3EPRBZNT1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-G3EPRBZNT1');
</script>
<?= $this->general_settings->custom_css_codes; ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?= $this->general_settings->google_adsense_code; ?>
</head>
<body>
<header id="header">
    <?php // $this->load->view("partials/_top_bar"); ?>
    <div class="main-menu">
        <div class="container-fluid">
            <div class="row">
                <div class="nav-top">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-3 nav-top-left" style="flex: 0 0 25%; max-width: 25%;">
                                <div class="row-align-items-center">
                                    <div class="logo">
                                        <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 nav-top-left" style="flex: 0 0 50%; max-width: 50%;">
                                <div class="row-align-items-center">
                                    <div class="top-search-bar<?= $this->general_settings->multi_vendor_system != 1 ? ' top-search-bar-single-vendor' : ''; ?>" style="width: calc(100% - 100px);">
                                        <?php echo form_open(generate_url('search'), ['id' => 'form_validate_search', 'class' => 'form_search_main', 'method' => 'get']); ?>
                                        <div class="left">
                                            <div class="dropdown search-select">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><?= !empty($input_search_category) ? category_name($input_search_category) : trans("all_categories"); ?></button>
                                                <i class="icon-arrow-down search-select-caret"></i>
                                                <input type="hidden" name="search_category_input" id="input_search_category" value="<?= !empty($input_search_category) ? $input_search_category->id : 'all'; ?>">
                                                <div class="dropdown-menu search-categories">
                                                    <a class="dropdown-item" data-value="all" href="javascript:void(0)"><?= trans("all_categories"); ?></a>
                                                    <?php if (!empty($this->parent_categories)):
                                                        foreach ($this->parent_categories as $search_cat):?>
                                                            <a class="dropdown-item" data-value="<?= $search_cat->id; ?>" href="javascript:void(0)"><?= html_escape($search_cat->name); ?></a>
                                                        <?php endforeach;
                                                    endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_exp"); ?>" required autocomplete="off">
                                            <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                                            <div id="response_search_results" class="search-results-ajax"></div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 nav-top-right" style="flex: 0 0 25%; max-width: 25%;">
                                <ul class="nav align-items-center">
                                    <li class="nav-item dropdown language-dropdown nav-item-language li-main-nav-right">
                                      <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-language"></i>
                                        <span class="info"><?php echo case_converter($this->selected_lang->short_form, 'u'); ?> </span>
                                      </a>
                                      <div class="dropdown-menu">
                                        <?php foreach ($this->languages as $language): ?>
                                        <a href="<?php echo convert_url_by_language($language); ?>" class="dropdown-item <?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?>">
                                        <?php echo case_converter($language->short_form, 'u'); ?> - <?php echo $language->name; ?>
                                        </a>
                                        <?php endforeach; ?>
                                      </div>
                                    </li>
                                    <?php if ($this->is_sale_active): ?>
                                        <li class="nav-item nav-item-cart li-main-nav-right">
                                            <a href="<?php echo generate_url("cart"); ?>">
                                                <i class="icon-cart"></i><!-- <span><?php echo trans("cart"); ?></span> -->
                                                <?php $cart_product_count = get_cart_product_count(); ?>
                                                <span class="notification span_cart_product_count <?= $cart_product_count <= 0 ? 'visibility-hidden' : ''; ?>"><?php echo $cart_product_count; ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($this->auth_check): ?>
                                        <li class="nav-item li-main-nav-right">
                                            <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                                <i class="icon-heart-o"></i><!-- <?php echo trans("wishlist"); ?> -->
                                            </a>
                                        </li>
                                        <?php /* ?>
                                        <li class="nav-item dropdown profile-dropdown p-r-0 li-main-nav-right">
                                            <a data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false" style="padding-bottom: 0px; padding-top: 6px">
                                                <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>" style="width: 28px; border-radius: 50%;">
                                            </a>
                                            <style media="screen">
                                              .profile-dropdown .dropdown-menu li a i {
                                                font-size: .9375rem;
                                              }
                                            </style>
                                            <ul class="dropdown-menu custom">
                                              <li>
                                                <a href="<?php echo admin_url(); ?>">
                                                <i class="icon-admin"></i>
                                                <?php echo trans("admin_panel"); ?>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="<?php echo generate_url("settings", "update_profile"); ?>">
                                                <i class="icon-settings"></i>
                                                <?php echo trans("settings"); ?>
                                                </a>
                                              </li>
                                              <li>
                                                <a href="<?php echo base_url(); ?>logout" class="logout">
                                                <i class="icon-logout"></i>
                                                <?php echo trans("logout"); ?>
                                                </a>
                                              </li>
                                            </ul>
                                        </li>
                                        <?php */ ?>
                                        <li class="nav-item li-main-nav-right">
                                          <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link new-profile">
                                            <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>" style="width: 28px; border-radius: 50%;">
                                            <?php if ($unread_message_count > 0): ?>
                                            <span class="notification"><?php echo $unread_message_count; ?></span>
                                            <?php endif; ?>
                                          </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="nav-item li-main-nav-right">
                                            <a href="<?php echo generate_url("wishlist"); ?>" style="padding-right:0">
                                                <i class="icon-heart-o"></i><!-- <?php echo trans("wishlist"); ?> -->
                                            </a>
                                        </li>

                                        <li class="nav-item li-main-nav-right">
                                          <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link">
                                            <i class="icon-user"></i>
                                          </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php /* if ($this->auth_check): ?>
                                        <?php if (is_multi_vendor_active()): ?>
                                            <li class="nav-item m-r-0"><a href="<?php echo generate_dash_url("add_product"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0"><?= trans("sell_now"); ?></a></li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (is_multi_vendor_active()): ?>
                                            <li class="nav-item m-r-0"><a href="javascript:void(0)" class="btn btn-md btn-custom btn-sell-now m-r-0" data-toggle="modal" data-target="#loginModal"><?= trans("sell_now"); ?></a></li>
                                        <?php endif; ?>
                                    <?php endif; */ ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-main">
                    <?php $this->load->view("partials/_nav_main"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-nav-container">
        <div class="nav-mobile-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="nav-mobile-header-container">
                        <div class="menu-icon">
                            <a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
                        </div>
                        <div class="mobile-logo">
                            <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo" class="logo"></a>
                        </div>
                        <div class="mobile-search">
                            <a class="search-icon"><i class="icon-search"></i></a>
                        </div>
                        <div class="mobile-cart<?= !$this->is_sale_active ? ' visibility-hidden' : ''; ?>">
                            <a href="<?php echo generate_url("cart"); ?>"><i class="icon-cart"></i>
                              <?php $cart_product_count = get_cart_product_count(); ?>
                              <span class="notification span_cart_product_count <?= $cart_product_count <= 0 ? 'visibility-hidden' : ''; ?>"><?php echo $cart_product_count; ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="top-search-bar mobile-search-form <?= $this->general_settings->multi_vendor_system != 1 ? ' top-search-bar-single-vendor' : ''; ?>">
                        <?php echo form_open(generate_url('search'), ['id' => 'form_validate_search_mobile', 'method' => 'get']); ?>
                        <div class="left">
                            <div class="dropdown search-select">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><?= !empty($input_search_category) ? category_name($input_search_category) : trans("all_categories"); ?></button>
                                <i class="icon-arrow-down search-select-caret"></i>
                                <input type="hidden" name="search_category_input" id="input_search_category_mobile" value="<?= !empty($input_search_category) ? $input_search_category->id : 'all'; ?>">
                                <div class="dropdown-menu search-categories">
                                    <a class="dropdown-item" data-value="all" href="javascript:void(0)"><?= trans("all_categories"); ?></a>
                                    <?php if (!empty($this->parent_categories)):
                                        foreach ($this->parent_categories as $search_cat):?>
                                            <a class="dropdown-item" data-value="<?= $search_cat->id; ?>" href="javascript:void(0)"><?= html_escape($search_cat->name); ?></a>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <input type="text" id="input_search_mobile" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search"); ?>" required autocomplete="off">
                            <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                            <div id="response_search_results_mobile" class="search-results-ajax"></div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="overlay_bg" class="overlay-bg"></div>
<!--include mobile menu-->
<?php $this->load->view("partials/_nav_mobile"); ?>
<input type="hidden" class="search_type_input" name="search_type" value="product">
<?php if (!$this->auth_check): ?>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered login-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <h4 class="title"><?php echo trans("login"); ?></h4>
                    <!-- form start -->
                    <form id="form_login" novalidate="novalidate">
                        <div class="social-login">
                            <?php $this->load->view("partials/_social_login", ["or_text" => trans("login_with_email")]); ?>
                        </div>
                        <!-- include message block -->
                        <div id="result-login" class="font-size-13"></div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" autocomplete="off" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" autocomplete="off" minlength="4" maxlength="255" required>
                        </div>
                        <div class="form-group text-right">
                            <a href="<?php echo generate_url("forgot_password"); ?>" class="link-forgot-password"><?php echo trans("forgot_password"); ?></a>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("login"); ?></button>
                        </div>

                        <p class="p-social-media m-0 m-t-5"><?php echo trans("dont_have_account"); ?>&nbsp;<a href="<?php echo generate_url("register"); ?>" class="link"><?php echo trans("register"); ?></a></p>
                    </form>
                    <!-- form end -->
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" role="dialog">
      <div class="modal-dialog modal-dialog-centered login-modal" role="document">
          <div class="modal-content">
              <div class="auth-box">
                  <button type="button" class="close" data-dismiss="modal" style="z-index: 9999"><i class="icon-close"></i></button>
                  <div class="row align-items-center" style="margin-bottom: 15px;">
                    <div class="col-4">
                      <img style="width: 100%; border:solid 1px #eee" src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>" class="lazyload img-responsive post-image"/>
                    </div>
                    <div class="col-8">
                      <a>
                        <?=$this->auth_user->first_name?> <?=$this->auth_user->last_name?>
                      </a>
                      <p class="info">
                        <?php echo $this->auth_user->phone_number; ?>
                        <br>
                        <?php echo character_limiter($this->auth_user->email, 20, '..'); ?>
                      </p>
                    </div>
                  </div>

                  <style media="screen">
                    .account-menu a {margin: 2.5px 1.5px; text-align: center;}
                    .account-menu a i {font-size: 1.5rem;}
                  </style>
                  <div class="row justify-content-center" style="padding: 10px;">
                    <?php if ($this->auth_user->role == "admin"): ?>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo admin_url(); ?>" class="list-group-item list-group-item-action border">
                        <i class="icon-admin"></i>
                        <br>
                        <?php echo trans("admin_panel"); ?>
                      </a>
                    </div>
                    <?php endif; ?>
                    <?php if (is_user_vendor()): ?>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo dashboard_url(); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-dashboard"></i>
                          <br>
                          <?php echo trans("dashboard"); ?>
                      </a>
                    </div>
                    <?php endif; ?>
                    <?php if ($this->is_sale_active): ?>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("orders"); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-shopping-basket"></i>
                          <br>
                          <?php echo trans("orders"); ?>
                      </a>
                    </div>
                    <?php if (is_bidding_system_active()): ?>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("quote_requests"); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-price-tag-o"></i>
                          <br>
                          <?php echo trans("quote_requests"); ?>
                      </a>
                    </div>
                    <?php endif; ?>
                    <?php if ($this->general_settings->digital_products_system == 1): ?>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("downloads"); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-download"></i>
                          <br>
                          <?php echo trans("downloads"); ?>
                      </a>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("messages"); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-mail"></i>
                          <br>
                          <?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0): ?>
                          <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                          <?php endif; ?>
                      </a>
                    </div>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("settings", "shipping_address"); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-search"></i>
                          <br>
                          <?php echo trans("my_address"); ?>
                      </a>
                    </div>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-heart-o"></i>
                          <br>
                          <?php echo trans("wishlist"); ?>
                      </a>
                    </div>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo generate_url("settings", "update_profile"); ?>" class="list-group-item list-group-item-action border">
                          <i class="icon-settings"></i>
                          <br>
                          <?php echo trans("settings"); ?>
                      </a>
                    </div>
                    <div class="col-6 list-group account-menu">
                      <a href="<?php echo base_url(); ?>logout" class="list-group-item list-group-item-action border">
                          <i class="icon-logout"></i>
                          <br>
                          <?php echo trans("logout"); ?>
                      </a>
                    </div>
                  </div> <!-- row-->
                </div> <!-- authbox-->
              </div>
          </div>
      </div>
  </div>
<?php endif; ?>

<?php if ($this->general_settings->location_search_header == 1): ?>
    <div class="modal fade" id="locationModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered login-modal location-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <h4 class="title text-left"><?php echo trans("select_location"); ?></h4>
                    <p class="location-modal-description"><?php echo trans("location_exp"); ?></p>
                    <div class="form-group m-b-20">
                        <div class="input-group input-group-location">
                            <i class="icon-map-marker"></i>
                            <input type="text" id="input_location" class="form-control form-input" value="<?= $this->default_location_input; ?>" placeholder="<?php echo trans("enter_location") ?>" autocomplete="off">
                            <a href="javascript:void(0)" class="btn-reset-location-input<?= (empty($this->default_location->country_id)) ? ' hidden' : ''; ?>"><i class="icon-close"></i></a>
                        </div>
                        <div class="search-results-ajax">
                            <div class="search-results-location">
                                <div id="response_search_location"></div>
                            </div>
                        </div>
                        <div id="location_id_inputs">
                            <input type="hidden" name="country" value="<?= $this->default_location->country_id; ?>" class="input-location-filter">
                            <input type="hidden" name="state" value="<?= $this->default_location->state_id; ?>" class="input-location-filter">
                            <input type="hidden" name="city" value="<?= $this->default_location->city_id; ?>" class="input-location-filter">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btn_submit_location" class="btn btn-md btn-custom btn-block"><?php echo trans("update_location"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="menu-overlay"></div>
