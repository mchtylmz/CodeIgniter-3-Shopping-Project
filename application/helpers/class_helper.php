<?php

//  yidasModel
if (!function_exists('yidasModel')) {
    function yidasModel()
    {
				include_once APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'yidas' . DIRECTORY_SEPARATOR . 'yidasModel.php';
    }
}

//  myModel
if (!function_exists('new_model')) {
    function new_model($name, $timestamps = true)
    {
				yidasModel();
        $ci =& get_instance();
        if (!class_exists($name)) {
          eval("class " . $name . " extends yidasModel {const CREATED_AT = ".($timestamps ? "'created_at'":"NULL")."; const UPDATED_AT = NULL;}");
        }
				return new $name();
    }
}

//  variation_options
if (!function_exists('variation_options')) {
    function variation_options()
    {
				yidasModel();
        images_variation();
        if (!class_exists('variation_options')) {
  				class variation_options extends yidasModel {
  					protected $timestamps = false;
            public function images() {
  			        return $this->hasMany('images_variation', 'variation_option_id', 'id');
  			    }
            public function total_stock_parent($nebim_option = '')
            {
              return $this->find()->select('sum(stock) as total')
                                  ->where('parent_id', $this->id)
                                  ->where('nebim_option !=', $nebim_option)
                                  ->get()
                                  ->row()
                                  ->total ?? $this->stock;
            }
  				}
        } // class_exists
				return new variation_options();
    }
}

//  variations_model
if (!function_exists('variations_model')) {
    function variations_model()
    {
				yidasModel();
        variation_options();
        if (!class_exists('variations')) {
  				class variations extends yidasModel {
            const CREATED_AT = NULL;
            const UPDATED_AT = 'updated_at';
  					public function options() {
  			        return $this->hasMany('variation_options', 'variation_id', 'id');
  			    }
  				}
        } // class_exists
				return new variations();
    }
}

//  images
if (!function_exists('images')) {
    function images()
    {
				yidasModel();
        if (!class_exists('images')) {
  				class images extends yidasModel {
            const CREATED_AT = NULL;
            const UPDATED_AT = 'updated_at';
  				}
        } // class_exists
				return new images();
    }
}

//  images_variation
if (!function_exists('images_variation')) {
    function images_variation()
    {
				yidasModel();
        if (!class_exists('images_variation')) {
  				class images_variation extends yidasModel {
            const CREATED_AT = NULL;
            const UPDATED_AT = 'updated_at';
  				}
        } // class_exists
				return new images_variation();
    }
}

//  users_model
if (!function_exists('users_model')) {
    function users_model()
    {
				yidasModel();
        if (!class_exists('users')) {
  				class users extends yidasModel {
            const CREATED_AT = 'created_at';
            const UPDATED_AT = NULL;
  				}
        } // class_exists
				return new users();
    }
}


//  product_detail
if (!function_exists('product_detail')) {
    function product_detail()
    {
				yidasModel();
        if (!class_exists('product_details')) {
  				class product_details extends yidasModel {
  					protected $timestamps = false;
  				}
        } // class_exists
				return new product_details();
    }
}

//  product_model
if (!function_exists('product_model')) {
    function product_model()
    {
				yidasModel();
        images();
        variations_model();
        if (!class_exists('products') && !class_exists('product_details')) {
  				class product_details extends yidasModel {
  					protected $timestamps = false;
  				}
  				class products extends yidasModel {
  					const CREATED_AT = 'created_at';
            const UPDATED_AT = NULL;
  					public function details() {
  			        return $this->hasMany('product_details', 'product_id', 'id');
  			    }
            public function variations() {
  			        return $this->hasMany('variations', 'product_id', 'id');
  			    }
            public function images() {
  			        return $this->hasMany('images', 'product_id', 'id');
  			    }
            public function variation_total_stock() {
                /*
                SELECT sum(variation_options.stock) FROM `products`
                inner join variations on variations.product_id = products.id
                inner join variation_options on variation_options.variation_id = variations.id
                where products.id = ...
                */
  			        return $this->find()->join('variations', 'variations.product_id = products.id')
                                    ->join('variation_options', 'variation_options.variation_id = variations.id')
                                    ->select('sum(variation_options.stock) as totalStock')
                                    ->where('products.id', $this->id)
                                    ->where('variations.nebim_option', 'Beden')
                                    ->get()
                                    ->row()
                                    ->totalStock ?? 0;
  			    }
  				}
        } // class_exists
				return new products();
    }
}

//  orders_model
if (!function_exists('orders_model')) {
    function orders_model()
    {
				yidasModel();
        users_model();
        if (!class_exists('orders')) {
  				class order_products extends yidasModel {
  					protected $timestamps = false;
  				}
          class order_shipping extends yidasModel {
  					protected $timestamps = false;
  				}
  				class orders extends yidasModel {
            protected $timestamps = false;
  					public function products() {
  			        return $this->hasMany('order_products', 'order_id', 'id');
  			    }
            public function user() {
  			        return $this->hasMany('users', 'id', 'buyer_id');
  			    }
            public function shipping() {
  			        return $this->hasMany('order_shipping', 'order_id', 'id');
  			    }
  				}
        } // class_exists
				return new orders();
    }
}

//  categories_lang
if (!function_exists('categories_lang')) {
    function categories_lang()
    {
				yidasModel();
        if (!class_exists('categories_lang')) {
  				class categories_lang extends yidasModel {
  					protected $timestamps = false;
  				}
        } // class_exists
				return new categories_lang();
    }
}

//  categories_model
if (!function_exists('categories_model')) {
    function categories_model()
    {
				yidasModel();
        categories_lang();
        if (!class_exists('categories')) {
  				class categories extends yidasModel {
  					public function details() {
  			        return $this->hasMany('categories_lang', 'category_id', 'id');
  			    }
  				}
        } // class_exists
				return new categories();
    }
}

//  custom_fields
if (!function_exists('custom_fields')) {
    function custom_fields_model()
    {
				yidasModel();
				if (!class_exists('custom_fields')) {
          class custom_fields extends yidasModel {
            protected $timestamps = false;
          }
        }
				return new custom_fields();
    }
}

//  nebim_queue
if (!function_exists('nebim_queue')) {
    function nebim_queue()
    {
				yidasModel();
				if (!class_exists('queue')) {
          class nebim_queue extends yidasModel {}
        }
				return new nebim_queue();
    }
}

//  nebim_getproducts
if (!function_exists('nebim_getproducts')) {
    function nebim_getproducts()
    {
				yidasModel();
				if (!class_exists('nebim_getproducts')) {
          class nebim_getproducts extends yidasModel {
            const CREATED_AT = 'created_at';
            const UPDATED_AT = NULL;
            public function variation_option_for_image() {
                return $this->find()->join('products', 'products.sku = nebim_getproducts.ModelKodu')
                ->join('variations', 'variations.product_id = products.id and variations.show_images_on_slider = 1')
                ->join('variation_options', 'variation_options.variation_id = variations.id')
                ->select('nebim_getproducts.*, variation_options.id as optionID, variations.id as varitationID, products.id AS productID')
                ->where('variations.nebim_option', 'Renk')
                ->where('nebim_getproducts.id', $this->id)
                ->where('variation_options.nebim_option', $this->RenkAdi)
                ->get()
                ->row();
  			    }
          }
        }
				return new nebim_getproducts();
    }
}

// save_paynet_pos
if (!function_exists('save_paynet_pos')) {
    function save_paynet_pos(array $data)
    {
      $ci =& get_instance();
      new_model('paynet_pos')->insert([
        'bank_code'    => clean_str($data['bank_code'] ?? 0),
        'is_succeed'   => clean_number($data['is_succeed'] ?? 0),
        'response_code'=> clean_number($data['response_code'] ?? 500),
        'response'     => json_encode($data['response'] ?? null),
        'data'         => json_encode($data['data'] ?? null),
        'session'      => json_encode($_SESSION),
        'reference_no' => clean_number($data['reference_no'] ?? 0),
        'ip_address'   => $ci->input->ip_address()
      ]);
      return new_model('paynet_pos')->getLastInsertID();
    }
}

// *************************************** //


//  queue run get
if (!function_exists('product_queue_run_get')) {
    function product_queue_run_get($nebimProduct, $addProduct = true)
    {
      try {
        $category_id = product_category_id($nebimProduct);
        // *************
        $product_model = product_model();
        $product_detail= product_detail();
        $product_data  = [
          'slug'          => str_slug($nebimProduct->ModelKodu),
          'sku'           => $nebimProduct->ModelKodu,
          'category_id'   => $category_id,
          'price'         => $nebimProduct->IlkFiyat * 100,
          'discount_rate' => discount_rate($nebimProduct->IlkFiyat, $nebimProduct->IndirimFiyat),
          'visibility'    => 0,
          //'is_draft'      => 0
        ];
        if ($db_product = $product_model->findOne(['sku' => $nebimProduct->ModelKodu])) {
          $product_data['visibility'] = boolval($db_product->images);
          // $product_data['is_draft'] = !boolval($db_product->images);
          $product_model->update($product_data, $db_product->id);
          // Update Detail
          $product_detail->batchUpdate([
            [['title' => clean_str($nebimProduct->CinsiyetID .' ' . $nebimProduct->Sinif)], ['lang_id' => 1, 'product_id' => $db_product->id]],
            [['title' => clean_str($nebimProduct->Cinsiyet .' ' . $nebimProduct->Sinif)], ['lang_id' => 2, 'product_id' => $db_product->id]]
          ]);
          show_message('Ürün güncellendi');
        } else {
          if (!$addProduct) {
            show_message('!!! Ürün Pas Geçildi !!!!');
            throw new \Exception("Ürün Pas Geçildi", 404);
          } // if addProduct
          if (!$db_product = add_product($product_data)) {
            throw new \Exception("Ürün Eklenemedi", 404);
          }
          // Add Detail
          $product_detail->batchInsert([
            ['product_id' => $db_product->id, 'lang_id' => 1, 'title' => clean_str($nebimProduct->CinsiyetID .' ' . $nebimProduct->Sinif)],
            ['product_id' => $db_product->id, 'lang_id' => 2, 'title' => clean_str($nebimProduct->Cinsiyet .' ' . $nebimProduct->Sinif)],
          ]);
          show_message('Ürün eklendi');
        } // if product_model->findOne
        // *************
        product_variation($nebimProduct, $db_product);
        // *************
        $total_stock = intval($db_product->variation_total_stock());
        $product_model->update([
          'slug'     => str_slug($nebimProduct->ModelKodu .'-'. $db_product->id),
          'stock'    => $total_stock,
          //'is_draft' => $total_stock ? 0:1,
          'status'   => $total_stock ? 1:0
        ], $db_product->id);
        // *************
        $nebimProduct->update(['status' => 1], $nebimProduct->id);
        // *************
        return $product_model;
      } catch (\Exception $err) {
        http_response_code(404);
        header('HTTP/1.0 404 Not Found');
        echo json_encode([
          'message' => $err->getMessage()
        ]);
        exit;
      } // try
    }
}

//  custom_field
if (!function_exists('custom_field_category')) {
    function custom_field_category(int $field_id, int $category_id)
    {
      if (!$field_id || !$category_id) {
        return false;
      }
      $custom_fields_category = new_model('custom_fields_category', false);
      $cf_data = [
        'category_id' => clean_number($category_id),
        'field_id'    => clean_number($field_id)
      ];
      if (!$custom_fields_category->findOne($cf_data)) {
        $custom_fields_category->insert($cf_data);
      }
      return $cf_data['field_id'];
    }
}

//  custom_field_option_save
if (!function_exists('custom_field_option_save')) {
    function custom_field_option_save(int $field_id, array $cf_data)
    {
      if (!$field_id || !$cf_data) {
        return false;
      }

      $cf_options_model = new_model('custom_fields_options', false);
      $cf_options_lang  = new_model('custom_fields_options_lang', false);

      // slug
      $option_key = str_slug($cf_data['option_tr']);
      $field_id = clean_number($field_id);
      if ($db_cfoption = $cf_options_model->findOne(['option_key' => $option_key, 'field_id' => $field_id])) {
        $cf_options_lang->batchUpdate([
          [['option_name' => $cf_data['option_en']], ['lang_id' => 1, 'option_id' => $db_cfoption->id]],
          [['option_name' => $cf_data['option_tr']], ['lang_id' => 2, 'option_id' => $db_cfoption->id]]
        ]);
        $cf_option_id = $db_cfoption->id;
      } else {
        $cf_options_model->insert([
          'option_key' => $option_key, 'field_id' => $field_id
        ]);
        $cf_option_id = $cf_options_model->getLastInsertID();
        $cf_options_lang->batchInsert([
          ['option_id' => $cf_option_id, 'lang_id' => 1, 'option_name' => $cf_data['option_en']],
          ['option_id' => $cf_option_id, 'lang_id' => 2, 'option_name' => $cf_data['option_tr']],
        ]);
      } // if category_slug

      return $cf_option_id ?? 1;
    }
}

//  custom_field_product
if (!function_exists('custom_field_product')) {
    function custom_field_product(int $field_id, array $data)
    {
      if (!$field_id || !$data || !isset($data['product_id'])) {
        return false;
      }

      $cf_product_model = new_model('custom_fields_product', false);
      if (!$db_customfield = new_model('custom_fields')->findOne($field_id)) {
        return false;
      }

      $data = [
        'product_id' => clean_number($data['product_id']),
        'field_id'   => $db_customfield->id,
        'product_filter_key' => $db_customfield->product_filter_key,
        'selected_option_id' => $data['option_id'] ?? 1
      ];
      if (!$cf_product_model->findOne($data)) {
        $cf_product_model->insert($data);
      } // if cf_product_model

      return $cf_product_model->getLastInsertID();
    }
}

//  product_category_id
if (!function_exists('product_category_id')) {
    function product_category_id($nebimProduct)
    {
        /*
        'CinsiyetID' => $nebimProduct->CinsiyetID,
        'Cinsiyet'   => $nebimProduct->Cinsiyet,
        'KategoriID' => $nebimProduct->KategoriID,
        'Kategori'   => $nebimProduct->Kategori,
        'SinifID'    => $nebimProduct->SinifID,
        'Sinif'      => $nebimProduct->Sinif
        */
        if (!isset($nebimProduct->CinsiyetID) || !$nebimProduct->CinsiyetID) {
          throw new \Exception("CinsiyetID bilgisi boş olamaz!.", 404);
        }
        if (!isset($nebimProduct->KategoriID) || !$nebimProduct->KategoriID) {
          return 1;
        }

				$category_model  = categories_model();
        $categories_lang = categories_lang();

        // CinsiyetID
        $cinsiyet_categoryID = category_save([
          'slug' => clean_str($nebimProduct->Cinsiyet),
          'name_en' => clean_str($nebimProduct->CinsiyetID),
          'name_tr' => clean_str($nebimProduct->Cinsiyet),
          'parent_id' => 0
        ]);
        // custom field renk
        if ($field_id = get_general_setting('nebim_renk_customfield')) {
          custom_field_category($field_id, $cinsiyet_categoryID);
        }
        // custom field beden
        if ($field_id = get_general_setting('nebim_beden_customfield')) {
          custom_field_category($field_id, $cinsiyet_categoryID);
        }

        // KategoriID
        $kategori_categoryID = category_save([
          'slug' => clean_str($nebimProduct->Kategori) .'-'. $cinsiyet_categoryID,
          'name_en' => clean_str($nebimProduct->KategoriID),
          'name_tr' => clean_str($nebimProduct->Kategori),
          'parent_id' => $cinsiyet_categoryID,
          'parent_tree' => "$cinsiyet_categoryID"
        ]);

        // SinifID
        $sinif_categoryID = category_save([
          'slug' => clean_str($nebimProduct->Sinif) .'-'. $kategori_categoryID,
          'name_en' => clean_str($nebimProduct->Sinif),
          'name_tr' => clean_str($nebimProduct->Sinif),
          'parent_id'   => $kategori_categoryID,
          'parent_tree' => "$cinsiyet_categoryID,$kategori_categoryID"
        ]);

        return $sinif_categoryID ?? 1;
    }
}

//  category_save
if (!function_exists('category_save')) {
    function category_save(array $data)
    {
      if (isset($data['slug']) != true || empty($data['slug'])) {
        return 1;
      }

      $category_model  = categories_model();
      $categories_lang = categories_lang();

      // slug
      $category_slug = str_slug(case_converter($data['slug'], 'l'));
      $parent_id = clean_number($data['parent_id'] ?? 0);
      if ($db_category = $category_model->findOne(['slug' => $category_slug, 'parent_id' => $parent_id])) {
        $categories_lang->batchUpdate([
          [['name' => $data['name_en']], ['lang_id' => 1, 'category_id' => $db_category->id]],
          [['name' => $data['name_tr']], ['lang_id' => 2, 'category_id' => $db_category->id]]
        ]);
        $db_category_id = $db_category->id;
      } else {
        $category_model->insert([
          'slug'           => $category_slug,
          'parent_id'      => $data['parent_id'] ?? 0,
          'parent_tree'    => $data['parent_tree'] ?? '',
          'category_order' => $data['category_order'] ?? 1,
        ]);
        $db_category_id = $category_model->getLastInsertID();
        $categories_lang->batchInsert([
          ['category_id' => $db_category_id, 'lang_id' => 1, 'name' => $data['name_en']],
          ['category_id' => $db_category_id, 'lang_id' => 2, 'name' => $data['name_tr']],
        ]);
      } // if category_slug

      return $db_category_id ?? 1;
    }
}

//  product_variation
if (!function_exists('product_variation')) {
    function product_variation($nebimProduct, $db_product)
    {
      /*
      'RenkAdi' => $nebimProduct->RenkAdi,
      'Beden'   => $nebimProduct->Beden,
      'Stok'    => $nebimProduct->Stok,
      */
      $RenkAdi_varitation = variation_save(['en' => 'Color', 'tr' => 'Renk'], [
        'product_id' => $db_product->id,
        // 'stock'      => $nebimProduct->Stok <= 0 ? 0:9999
      ]);
      if (!$RenkAdi_varitation) {
        throw new \Exception("Renk Varyasyonu İşlenemedi!.", 404);
      } // if RenkAdi_varitation
      $RenkAdi_vOption = variation_options_save(['en' => $nebimProduct->RenkAdi, 'tr' => $nebimProduct->RenkAdi], [
        'variation_id' => $RenkAdi_varitation->id,
        'parent_id'    => 0,
        'price'        => $nebimProduct->IlkFiyat * 100,
        'discount_rate'=> discount_rate($nebimProduct->IlkFiyat, $nebimProduct->IndirimFiyat),
        'stock'        => $nebimProduct->Stok, // $nebimProduct->Stok <= 0 ? 0:9999,
        'barcode'      => $nebimProduct->Barkod,
        'updated_at'    => strtotime($nebimProduct->created_at)
      ]);
      // custom field renk
      if ($field_id = get_general_setting('nebim_renk_customfield')) {
        $cf_option_id = custom_field_option_save($field_id, [
          'option_en' => $nebimProduct->RenkAdi, 'option_tr' => $nebimProduct->RenkAdi
        ]);
        custom_field_product($field_id, [
          'product_id' => $db_product->id, 'option_id' => $cf_option_id
        ]);
      }

      if ($RenkAdi_varitation && $RenkAdi_vOption) {
        $Beden_varitation = variation_save(['en' => 'Size', 'tr' => 'Beden'], [
          'product_id' => $db_product->id,
          // 'stock'      => clean_number($nebimProduct->Stok),
          'parent_id'  => $RenkAdi_varitation->id
        ]);
        if (!$Beden_varitation) {
          throw new \Exception("Beden Varyasyonu İşlenemedi!.", 404);
        } // if RenkAdi_varitation
        $Beden_vOption = variation_options_save(['en' => $nebimProduct->Beden, 'tr' => $nebimProduct->Beden], [
          'variation_id' => $Beden_varitation->id,
          'parent_id'    => $RenkAdi_vOption->id,
          'price'        => $nebimProduct->IlkFiyat * 100,
          'discount_rate'=> discount_rate($nebimProduct->IlkFiyat, $nebimProduct->IndirimFiyat),
          'stock'        => $nebimProduct->Stok,
          'barcode'      => $nebimProduct->Barkod,
          'updated_at'    => strtotime($nebimProduct->created_at)
        ]);
        // custom field beden
        if ($field_id = get_general_setting('nebim_beden_customfield')) {
          $cf_option_id = custom_field_option_save($field_id, [
            'option_en' => $nebimProduct->Beden, 'option_tr' => $nebimProduct->Beden
          ]);
          custom_field_product($field_id, [
            'product_id' => $db_product->id, 'option_id' => $cf_option_id
          ]);
        }
        change_variation_options_not_in(
          [$RenkAdi_varitation->id, $Beden_varitation->id], $nebimProduct->getTable(), $nebimProduct->ModelKodu
        );
      }
      return true;
    }
}

//  variation_save
if (!function_exists('variation_save')) {
    function variation_save(array $label, array $data)
    {
      if (!isset($data['product_id']) || !$data) {
        throw new \Exception("Ürün ID bilgisi yok!.", 404);
      }
      $variations_model  = variations_model();
      $variation_options = variation_options();
      $serialize_label   = serialize([
        ['lang_id' => 1, 'label' => $label['en']],
        ['lang_id' => 2, 'label' => $label['tr']],
      ]);
      $nebim_option = $label['tr'];
      $product_id = clean_number($data['product_id']);
      $parent_id  = clean_number($data['parent_id'] ?? 0);
      // ******
      $db_varitation = $variations_model->findOne(['nebim_option' => $nebim_option, 'product_id' => $product_id, 'parent_id' => $parent_id]);
      if ($db_varitation) {
        $variations_model->update([
          'label_names'  => $serialize_label,
          'show_images_on_slider' => $parent_id ? 0:1,
          'nebim_option' => $nebim_option,
          'variation_type' => 'radio_button',
          'option_display_type' => $parent_id ? 'text':'color',
          'insert_type'  => 'copy',
          'updated_at'   => date('Y-m-d H:i:s')
        ], $db_varitation->id);
      } else {
        $variations_model->insert([
          'product_id'   => $product_id,
          'user_id'      => 1,
          'parent_id'    => $parent_id,
          'label_names'  => $serialize_label,
          'nebim_option' => $nebim_option,
          'variation_type'        => 'radio_button',// 'dropdown', // 'radio_button',
          'show_images_on_slider' => $parent_id ? 0:1,
          'option_display_type' => $parent_id ? 'text':'color',
          'use_different_price'   => 1,
          'insert_type'  => 'copy',
          'updated_at'   => date('Y-m-d H:i:s')
        ]);
        $db_varitation = $variations_model->findOne(['id' => $variations_model->getLastInsertID()]);
      }
      return $db_varitation ?? false;
    }
}

//  variation_options_save
if (!function_exists('variation_options_save')) {
    function variation_options_save(array $label, array $data)
    {
      if (!isset($data['variation_id']) || !isset($data['price']) || !$data) {
        throw new \Exception("Varyasyon Seçeneğinde Eksik Bilgiler Var!.", 404);
      }
      if (!isset($data['time'])) {
        $data['updated_at'] = time() + 30;
      }
      $variation_options = variation_options();
      $serialize_label   = serialize([
        ['lang_id' => 1, 'option_name' => $label['en']],
        ['lang_id' => 2, 'option_name' => $label['tr']],
      ]);
      $nebim_option = $label['tr'];
      $variation_id = clean_number($data['variation_id']);
      $parent_id    = clean_number($data['parent_id'] ?? 0);
      $option_data  = [
        'option_names' => $serialize_label,
        'price'        => $data['price'],
        'discount_rate'=> $data['discount_rate'] ?? 0,
        'stock'        => $data['stock'] ?? 0,
        'barcode'      => $data['barcode'] ?? $label['tr'],
        'nebim_option' => $nebim_option
      ];
      // ******
      $db_varitation_options = $variation_options->findOne([
        'nebim_option' => $nebim_option, 'variation_id' => $variation_id, 'parent_id' => $parent_id
      ]);
      if ($db_varitation_options) {
        if ($data['updated_at'] < strtotime($db_varitation_options->updated_at)) {
          return false;
        }
        if ($parent_id == 0) {
          $option_data['stock'] += $db_varitation_options->total_stock_parent($nebim_option);
        }
        $variation_options->update($option_data, $db_varitation_options->id);
      } else {
        $variation_options->insert(array_merge($option_data, [
          'variation_id'  => $variation_id,
          'parent_id'     => $parent_id
        ]));
        $db_varitation_options = $variation_options->findOne(['id' => $variation_options->getLastInsertID()]);
      }
      return $db_varitation_options ?? false;
    }
}

//  images_save
if (!function_exists('images_save')) {
    function images_save(array $data)
    {
      $images = images();
      if (!$product_id = clean_number($data['product_id'])) {
        return false;
      }
      $nebim_option = $data['nebim_option'] ?? 0;
      // product_id
      $db_images = $images->findAll(['product_id' => $product_id]);
      if (count($db_images) <= 4) {
        $images->insert([
          'product_id'    => $data['product_id'],
          'image_default' => $data['image_default'],
          'image_big'     => $data['image_big'],
          'image_small'   => $data['image_small'],
          'is_main'       => 1,
          'nebim_option'  => $nebim_option
        ]);
      } else if ($db_images = $images->findOne(['product_id' => $product_id, 'updated_at <=' => calculate_time('-1 day')])) {
        $images->update([
          'image_default' => $data['image_default'],
          'image_big'     => $data['image_big'],
          'image_small'   => $data['image_small'],
          'nebim_option'  => $nebim_option
        ], $db_images->id);
      } // if images

      return $images->getLastInsertID();
    }
}

//  images_variation_save
if (!function_exists('images_variation_save')) {
    function images_variation_save(array $data)
    {
      $images_variation = images_variation();
      $product_id = clean_number($data['product_id']);
      $variation_option_id = clean_number($data['variation_option_id']);
      if (!$product_id || !$variation_option_id) {
        return false;
      }
      $nebim_option = $data['nebim_option'] ?? 0;
      // variation_option_id
      $db_images_variation = $images_variation->findAll(['variation_option_id' => $variation_option_id]);
      if (count($db_images_variation) <= 6) {
        $images_variation->insert([
          'product_id'    => $data['product_id'],
          'variation_option_id' => $data['variation_option_id'],
          'image_default' => $data['image_default'],
          'image_big'     => $data['image_big'],
          'image_small'   => $data['image_small'],
          'nebim_option'  => $nebim_option
        ]);
      } else if ($db_images_variation = $images_variation->findOne(['variation_option_id' => $variation_option_id, 'updated_at <=' => calculate_time('-1 day')])) {
        $images_variation->update([
          'image_default' => $data['image_default'],
          'image_big'     => $data['image_big'],
          'image_small'   => $data['image_small'],
          'nebim_option'  => $nebim_option
        ], $db_images_variation->id);
      } // if images_variation

      return $images_variation->getLastInsertID();
    }
}

//  add_product
if (!function_exists('add_product')) {
    function add_product($data)
    {
      $product_model = product_model();
      $product_model->insert(array_merge($data, [
        'currency'           => "TRY",
        'stock'              => 0,
        'user_id'            => 1,
        'status'             => 1,
        'is_promoted'        => 0,
        'visibility'         => 0,
        'promote_start_date' => date('Y-m-d H:i:s'),
        'promote_end_date'   => date('Y-m-d H:i:s'),
        'promote_plan'       => "none",
        'is_draft'           => 1
      ]));
      return $product_model->findOne(['id' => $product_model->getLastInsertID()]);
    }
}

//  change_products_not_in
if (!function_exists('change_products_not_in')) {
    function change_products_not_in()
    {
      $ci =& get_instance();
      $ci->db->query("
        UPDATE `products`
        SET `is_draft` = 1
        WHERE
          sku NOT IN (SELECT ModelKodu FROM `nebim_getproducts`) and
          (SELECT ModelKodu FROM `nebim_getproducts` LIMIT 1) IS NOT NULL
      ");
    }
}

//  change_variation_options_not_in
if (!function_exists('change_variation_options_not_in')) {
    function change_variation_options_not_in(array $variation_ids, string $table = '0', string $sku = '0')
    {
      if (!is_array($variation_ids)) {
        return false;
      }
      $variation_ids = implode(',', $variation_ids);
      $sku = clean_str($sku);
      if ($table == 'nebim_updateproducts') {
        $table = 'nebim_updateproducts';
      } else {
        $table = 'nebim_getproducts';
      }
      $ci =& get_instance();
      $ci->db->query("
        UPDATE `variation_options`
        SET `stock` = '0'
        WHERE
          `variation_id` IN($variation_ids) and
          `barcode` NOT IN (SELECT Barkod FROM `$table` WHERE ModelKodu = '$sku')
      ");
    }
}
