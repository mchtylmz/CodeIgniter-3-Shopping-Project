<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$groups = faq_group();
$page_content = json_decode($page->page_content, true);
?>
<style media="screen">
  .accordion button {
    background-color: transparent;
    color: black !important;
    padding: 3px 10px;
    text-decoration: none !important;
  }
</style>
<div id="wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="blog-content">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($page->title); ?></li>
                        </ol>
                    </nav>
                    <?php if ($page->title_active == 1): ?>
                        <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                    <?php endif; ?>
                    <?php foreach ($groups as $key => $name): ?>
                      <?php if (isset($page_content[$key]) && $page_content[$key]): ?>
                        <div class="row" style="margin: 5px 0 20px 0">
                          <div class="col-sm-3">
                            <h3 class="page-title" style="color:#ED1B24; padding-top: 16.5px; font-size: 16.5px"><?=$name?></h3>
                          </div>
                          <div class="col-sm-9">
                            <!-- soru cevap -->
                            <div class="accordion" id="accordion_<?=$key?>">
                              <?php foreach ($page_content[$key]['title'] as $ckey => $ctitle): ?>
                              <div class="card">
                                <div class="card-header" id="heading_<?=$key.$ckey?>">
                                  <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse_<?=$key.$ckey?>" aria-expanded="false" aria-controls="collapse_<?=$key.$ckey?>">
                                      <?=$ctitle?>
                                    </button>
                                  </h2>
                                </div>  <!-- accordion -->
                                <div id="collapse_<?=$key.$ckey?>" class="collapse" aria-labelledby="heading_<?=$key.$ckey?>" data-parent="#accordion_<?=$key?>">
                                  <div class="card-body">
                                    <?=$page_content[$key]['content'][$ckey]?>
                                  </div> <!-- body -->
                                </div> <!-- collapse -->
                              </div>  <!-- card -->
                              <?php endforeach; ?>
                            </div>  <!-- accordion -->
                            <!-- soru cevap -->
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>
