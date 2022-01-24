<?php  ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('update_page'); ?></h3>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('page_controller/update_page_post'); ?>
            <input type="hidden" name="id" value="<?php echo $page->id; ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo $page->title; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <?php if (empty($page->page_default_name)): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("slug"); ?>
                            <small>(<?php echo trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>"
                               value="<?php echo $page->slug; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="slug" value="<?= $page->slug; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="description"
                           placeholder="<?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo $page->description; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo $page->keywords; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control" style="max-width: 600px;">
                        <?php foreach ($this->languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($page->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo trans('sort'); ?></label>
                    <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans('sort'); ?>" value="<?php echo $page->page_order; ?>" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> style="max-width: 600px;">
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('location'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="location" value="top_menu" id="menu_top_menu" class="square-purple" <?php echo ($page->location == "top_menu") ? 'checked' : ''; ?>>
                            <label for="menu_top_menu" class="option-label"><?php echo trans('top_menu'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="location" value="quick_links" id="menu_quick_links" class="square-purple" <?php echo ($page->location == "quick_links") ? 'checked' : ''; ?>>
                            <label for="menu_quick_links" class="option-label"><?php echo trans('footer_quick_links'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="location" value="information" id="menu_information" class="square-purple" <?php echo ($page->location == "information") ? 'checked' : ''; ?>>
                            <label for="menu_information" class="option-label"><?php echo trans('footer_information'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('visibility'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="visibility" value="1" id="page_enabled"
                                   class="square-purple" <?php echo ($page->visibility == 1) ? 'checked' : ''; ?>>
                            <label for="page_enabled" class="option-label"><?php echo trans('show'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="visibility" value="0" id="page_disabled"
                                   class="square-purple" <?php echo ($page->visibility == 0) ? 'checked' : ''; ?>>
                            <label for="page_disabled" class="option-label"><?php echo trans('hide'); ?></label>
                        </div>
                    </div>
                </div>

                <?php if ($page->page_default_name != 'blog' && $page->page_default_name != 'contact'): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('show_title'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="title_active" value="1" id="title_enabled"
                                       class="square-purple" <?php echo ($page->title_active == 1) ? 'checked' : ''; ?>>
                                <label for="title_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="title_active" value="0" id="title_disabled"
                                       class="square-purple" <?php echo ($page->title_active == 0) ? 'checked' : ''; ?>>
                                <label for="title_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" value="1" name="title_active">
                <?php endif; ?>

                <?php if ($page->page_default_name != 'blog' && $page->page_default_name != 'contact' && $page->page_default_name != 'faq'): ?>
                    <div class="form-group" style="margin-top: 30px;">
                        <label><?php echo trans('content'); ?></label>
                        <div class="row">
                            <div class="col-sm-12 m-b-5">
                                <button type="button" class="btn btn-success btn-file-manager" data-image-type="editor" data-toggle="modal" data-target="#imageFileManagerModal"><i class="fa fa-image"></i>&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                            </div>
                        </div>
                        <textarea class="form-control tinyMCE" name="page_content"><?php echo $page->page_content; ?></textarea>
                    </div>
                <?php elseif ($page->page_default_name == 'faq') : ?>
                  <?php $page_content = json_decode($page->page_content, true) ?? []; ?>
                  <script src="<?php echo base_url(); ?>assets/admin/vendor/sortable/Sortable.js"></script>
                  <?php $groups = faq_group(); ?>
                  <style media="screen">
                    .mb-3 {margin-bottom: 6px}.fa-arrows-alt {float: right;font-size: 24px; vertical-align: middle;}label.group {width: 100%}
                  </style>
                  <br>
                  <div class="row" style="padding: 15px">
                      <div class="category-filters" style="display:flex; align-items: end">
                        <div class="item-filter">
                            <label><?php echo trans("options"); ?></label>
                            <select name="group_id" class="form-control" style="max-width: 600px;">
                                <?php foreach ($groups as $key => $name): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                          <div class="item-filter item-filter-select">
                            <button type="button" class="btn btn-success" onclick="newFAQ()"><?php echo trans("add_question_and_answer"); ?></button>
                          </div>
                      </div>
                  </div>
                  <div class="row" style="padding: 15px">
                      <div class="categories-panel-group nested-sortable" style="margin-top: 0; margin-bottom: 0">
                          <?php  foreach ($groups as $key => $name): ?>
                            <div id="panel_group_<?=$key?>" class="panel-group" draggable="false">
                                <div id="category_item_<?=$key?>" data-item-id="<?=$key?>" class="panel panel-default category-item">
                                    <div class="panel-heading" data-item-id="<?=$key?>" href="#collapse_<?=$key?>">
                                        <div class="left"><i class="fa fa-caret-right"></i> <?=case_converter($name, 'u')?></div>
                                        <div class="right"></div>
                                    </div>
                                    <div id="collapse_<?=$key?>" class="panel-collapse collapse" aria-expanded="false">
                                        <div class="panel-body nested-sortable" data-parent-id="<?=$key?>" style="padding: 15px">
                                          <?php if (isset($page_content[$key]) && $page_content[$key]): ?>
                                            <?php foreach ($page_content[$key]['title'] as $ckey => $ctitle): ?>
                                              <!-- soru cevap -->
                                              <div class="form-group" id="form_<?=$key.$ckey?>">
                                                <label class="group">
                                                  <i class="fa fa-arrows-alt"></i> <?php echo trans('title'); ?> / <?php echo trans('content'); ?>
                                                </label>
                                                <input type="text" class="form-control mb-3" name="faq[<?=$key?>][title][]" placeholder="<?=trans('title')?>" value="<?=$ctitle?>" required>
                                                <textarea class="form-control tinyMCExsmall" name="faq[<?=$key?>][content][]" rows="2" placeholder="<?=trans('content')?>"><?=$page_content[$key]['content'][$ckey]?></textarea>
                                                <center>
                                                <button type="button" class="btn btn-danger" onclick="deleteFAQ('<?=$key.$ckey?>')">
                                                  <?php echo trans("delete"); ?>
                                                </button>
                                                </center>
                                                <hr>
                                              </div>
                                              <!-- soru cevap -->
                                            <?php endforeach; ?>
                                          <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <?php endforeach; ?>
                      </div>
                  </div>
                  <script type="text/javascript">
                    function newFAQ() {
                      var rand = Math.floor(Math.random() * 999999);
                      var group_id = $("select[name=group_id]").val();
                      var html = '<div class="form-group" id="form_'+rand+'">'
                      + '<label class="group">'
                      + '<i class="fa fa-arrows-alt"></i> <?php echo trans('title'); ?> / <?php echo trans('content'); ?></label>'
                      + '<input type="text" class="form-control mb-3" name="faq['+group_id+'][title][]" placeholder="<?=trans('title')?>" required>'
                      + '<textarea class="form-control tinyMCExsmall" name="faq['+group_id+'][content][]" rows="2" placeholder="<?=trans('content')?>"></textarea>'
                      + '<center>'
                      + '<button type="button" class="btn btn-danger" onclick="deleteFAQ('+rand+')"><?php echo trans("delete"); ?></button>'
                      + '</center><hr>'
                      + '</div>';
                      $('#collapse_' + group_id).find('.panel-body').append(html);
                      $('.collapse').not('#collapse_' + group_id).collapse('hide');
                      $('#collapse_' + group_id).collapse('show');
                      init_tinymce('.tinyMCExsmall', 180);
                    }
                    function deleteFAQ(rand) {
                      $('#form_' + rand).remove();
                    }
                  </script>
                  <input type="hidden" value="" name="page_content">
                <?php else: ?>
                    <input type="hidden" value="" name="page_content">
                <?php endif; ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer" style="text-align:center">
                <button type="submit" class="btn btn-primary pull-center"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

<?php $this->load->view('admin/includes/_image_file_manager'); ?>

<script>
    var categories_array = JSON.parse(JSON.stringify([]));
    $(document).on("click", ".panel .panel-heading", function (e) {
        if ($(e.target).is('div') || $(e.target).is('span') || $(e.target).is('.fa-caret-right') || $(e.target).is('.fa-caret-down')) {
            var id = $(this).attr('data-item-id');
            $('#collapse_' + id).collapse("toggle");
            $('.left .fa', this).toggleClass('fa-caret-right').toggleClass('fa-caret-down');
        }
    });

    $(document).on("click", ".panel .panel-heading .btn-delete", function (e) {
        var id = $(this).attr('data-item-id');
        delete_item("category_controller/delete_category_post", id, "<?= trans("confirm_category");?>");
    });
    var nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));
    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            animation: 50,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            ghostClass: "sortable-chosen",
            chosenClass: "sortable-chosen",
            dragClass: "sortable-chosen",
            onEnd: function (event) {
                var i;
                for (i = 0; i < categories_array.length; i++) {
                    var parent_id = $("#category_item_" + categories_array[i].id).parent().closest(".category-item").attr("data-item-id");
                    var index = $("#panel_group_" + categories_array[i].id).index();
                    if (parent_id == null || parent_id == undefined) {
                        parent_id = 0;
                    }
                    if (index == null || index == undefined) {
                        index = 0;
                    }
                    categories_array[i].parent_id = parent_id;
                    categories_array[i].index = index + 1;
                }
                var data = {
                    'json_categories': JSON.stringify(categories_array)
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "category_controller/sort_categories_json",
                    data: data,
                    success: function (response) {
                    }
                });
            }
        });
    }
</script>
<style>
    .btn-group-option {
        display: inline-block !important;
    }
</style>
