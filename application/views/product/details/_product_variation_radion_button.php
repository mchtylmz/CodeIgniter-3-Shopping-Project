<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!isset($variation)) {
  return false;
}
if (!isset($variation_options)) {
  if ($variation->parent_id == 0) {
    $variation_options = get_product_variation_options($variation->id);
  } else {
    $default_option = get_variation_default_option($variation->parent_id);
    if (!empty($default_option)) {
      $variation_options = get_variation_sub_options($default_option->id);
    }
  }
} // !$variation_options

if (!empty($variation_options)):
    foreach ($variation_options as $key => $option):
        if ($option->is_default != 1):
            $option_stock = $option->stock;
        endif;
        $alternative_checked = $variation->parent_id == 0 && $option->is_default == 0 && $key == 0 && $option->stock >= 1;
        $option_name = get_variation_option_name($option->option_names, $this->selected_lang->id); ?>
        <div class="custom-control custom-control-variation custom-control-validate-input">
            <input type="radio" name="variation<?php echo $variation->id; ?>" data-name="variation<?php echo $variation->id; ?>" value="<?php echo $option->id; ?>" id="radio<?php echo $option->id; ?>" class="custom-control-input" <?php echo ($option->is_default == 1 || $alternative_checked) ? 'checked' : ''; ?> onchange="select_product_variation_option('<?php echo $variation->id; ?>', 'radio_button', $(this).val());" <?php echo ($option->stock< 1) ? 'data-out-of-stock="'.$option->id.'"' : ''; ?> required>
            <?php if ($variation->option_display_type == 'image'):
                $option_image = get_variation_main_option_image_url($option, $product_images); ?>
                <label for="radio<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label custom-control-label-image label-variation<?php echo $variation->id; ?> <?php echo ($option->stock < 1) ? 'option-out-of-stock' : ''; ?>">
                    <img src="<?php echo $option_image; ?>" class="img-variation-option" data-toggle="tooltip" data-placement="top" title="<?php echo html_escape($option_name); ?>" alt="<?php echo html_escape($option_name); ?>">
                </label>
            <?php elseif ($variation->option_display_type == 'color'): ?>
                <label for="radio<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label label-variation-color label-variation<?php echo $variation->id; ?> <?php echo ($option->stock< 1) ? 'option-out-of-stock' : ''; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo html_escape($option_name); ?>">
                    <span class="variation-color-box" style="background-color: <?php echo random_color();//$option->color; ?>; <?php echo ($option->stock < 1) ? 'background: linear-gradient(to left top, grey 47.75%, red 40%, red 60%, grey 52.25%);':''; ?>"></span>
                </label>
            <?php else: ?>
                <label for="radio<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label label-variation<?php echo $variation->id; ?> <?php echo ($option->stock < 1) ? 'option-out-of-stock' : ''; ?>">
                    <?php echo html_escape($option_name); ?>
                </label>
            <?php endif; ?>
        </div>
    <?php endforeach;
endif; ?>
