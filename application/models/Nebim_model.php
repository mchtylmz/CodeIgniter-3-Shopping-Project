<?php
set_time_limit(0);

class Nebim_model extends CI_Model
{
  private $table = 'nebim_getproducts';
  private $pk = 'id';

  private $session_id  = null;
  private $api_url     = "http://93.182.75.201:2366/";
  private $log_table   = 'nebim_logs';
  private $path        = [
    'tmp'     => FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR,
    'uploads' => FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR,
    'logs'    => APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'nebim' . DIRECTORY_SEPARATOR,
    'url'     => 'uploads/images/',
  ];
  private $w3_get_products_procedure    = "usp_GetProductPriceAndInventory_Amor_V2";
  private $w3_update_products_procedure = "usp_UpdateProductPriceAndInventory_Amor_V2";

  public function __construct()
  {
      parent::__construct();
      if ($general_settings = get_general_settings()) {
        $this->v3_office_code = $general_settings->nebim_office_code;
        $this->v3_store_code = $general_settings->nebim_store_code;
        $this->v3_ware_house = $general_settings->nebim_warehouse_code;
        $this->api_url = $general_settings->nebim_integrator_url;
      }
  }

  public function new_customer($user)
  {
      if (!is_object($user) || !$user) {
        throw new \Exception("Kullanıcı objesi bulunamadı!.", 404);
      }
      if (isset($user->curr_acc_code) && $user->curr_acc_code) {
        throw new \Exception("Kullanıcı müşteri kodu zaten kayıtlı!.", 404);
      }
      $this->__construct();
      // procedure data
      $data = [
        'ModelType'    => 3,
        'CurrAccCode'  => '',
        'FirstName'    => case_converter($user->first_name, 'u'),
        'LastName'     => case_converter($user->last_name, 'u'),
        'OfficeCode'   => $this->v3_office_code,
        'PostalAddresses' => [],
        'Communications' => [
          [
            'CommunicationTypeCode' => '3',
            'CommAddress'           => $user->email,
          ]
        ]
      ];
      $response = $this->post($data);
      // log
      $import_code = time();
      $this->logs([
        'name'     => 'new_customer',
        'data'     => json_encode($data),
        'response' => json_encode($response),
        'import'   => $user->id ?? $import_code,
        'type'     => isset($response['CurrAccCode']) ? 'success':'error'
      ]);
      // has error
      if ($err_message = $this->has_error($response)) {
        throw new \Exception($err_message, 500);
      }
      if (!isset($response['CurrAccCode'])) {
        throw new \Exception("CurrAccCode kodu bulunumadı!.", 404);
      }
      if (isset($user->id)) {
        $this->db->where('id', $user->id);
        $this->db->update('users', [
          'import_code'   => $user->id ?? $import_code,
          'curr_acc_code' => $response['CurrAccCode']
        ]);
      }
      return $response['CurrAccCode'] ?? false;
  }

  public function user_address($user, $order_shipping)
  {
      if (!is_object($user) || !$user) {
        throw new \Exception("Kullanıcı objesi bulunamadı!.", 404);
      }
      if (!$user->curr_acc_code) {
        throw new \Exception("Kullanıcı müşteri kodu bulunamadı!.", 404);
      }
      if (!is_object($order_shipping) || !$order_shipping) {
        throw new \Exception("order_shipping objesi bulunamadı!.", 404);
      }
      $this->__construct();
      // PostalAddressesv
      $PostalAddresses = [
        [
          'AddressTypeCode' => 1,
          'AddressID' => $order_shipping->biling_address_id,
          'PostalAddressID' => $order_shipping->biling_nebim_id,
          'ZipCode' => $order_shipping->billing_zip_code,
          'CountryCode' => $order_shipping->biling_nebim_country,
          'CityCode' => $order_shipping->billing_nebim_city,
          'StateCode' => $order_shipping->billing_nebim_state,
          'Address' => $order_shipping->billing_address . ' / ' . $order_shipping->billing_phone_number
        ]
      ];
      if ($order_shipping->biling_address_id != $order_shipping->shipping_address_id) {
        $PostalAddresses[] = [
          'AddressTypeCode' => 1,
          'AddressID' => $order_shipping->shipping_address_id,
          'PostalAddressID' => $order_shipping->shipping_nebim_id,
          'ZipCode' => $order_shipping->shipping_zip_code,
          'CountryCode' => $order_shipping->shipping_nebim_country,
          'CityCode' => $order_shipping->shipping_nebim_city,
          'StateCode' => $order_shipping->shipping_nebim_state,
          'Address' => $order_shipping->shipping_address . ' / ' . $order_shipping->shipping_phone_number
        ];
      }
      // procedure data
      $data = [
        'ModelType'    => 3,
        'CurrAccCode'  => $user->curr_acc_code,
        'FirstName'    => case_converter($user->first_name, 'u'),
        'LastName'     => case_converter($user->last_name, 'u'),
        'OfficeCode'   => $this->v3_office_code,
        'PostalAddresses' => $PostalAddresses
      ];
      $response = $this->post($data);

      // log
      $this->logs([
        'name'     => 'user_address',
        'data'     => json_encode($data),
        'response' => json_encode($response),
        'import'   => $order_shipping->id ?? $user->id,
        'type'     => isset($response['CurrAccCode']) ? 'success':'error'
      ]);

      // has error
      if ($err_message = $this->has_error($response)) {
        throw new \Exception($err_message, 500);
      }
      // TODO: gelen PostalAddresses al ve AddressID göre bul ve eşle PostalAddressID al
      if (isset($response['PostalAddresses']) && $PostalAddresses = $response['PostalAddresses']) {
        foreach ($PostalAddresses as $key => $address) {

          if ($address['AddressID'] == $order_shipping->biling_address_id) {
            $order_shipping->biling_nebim_id = $address['PostalAddressID'];
            // biling_address_id
            $this->db->where('id', $order_shipping->biling_address_id);
            $this->db->update('shipping_addresses', [
              'nebim_id' => $order_shipping->biling_nebim_id
            ]);
            // order_shipping
            $this->db->where('biling_address_id', $order_shipping->biling_address_id);
            $this->db->update('order_shipping', [
              'biling_nebim_id' => $order_shipping->biling_nebim_id
            ]);
          }  // biling_nebim_id

          if ($address['AddressID'] == $order_shipping->shipping_address_id) {
            $order_shipping->shipping_nebim_id = $address['PostalAddressID'];
            // shipping_addresses
            $this->db->where('id', $order_shipping->shipping_address_id);
            $this->db->update('shipping_addresses', [
              'nebim_id' => $order_shipping->shipping_nebim_id
            ]);
            // order_shipping
            $this->db->where('shipping_address_id', $order_shipping->shipping_address_id);
            $this->db->update('order_shipping', [
              'shipping_nebim_id' => $order_shipping->shipping_nebim_id
            ]);
          }  // shipping_address_id

        } // foreach
      } // PostalAddresses

      return $order_shipping;
  }

  public function new_order($order)
  {
    if (!$order || !is_object($order)) {
      throw new \Exception("Order objesi bulunamadı!.", 404);
    }
    if (isset($order->nebim_order) && $order->nebim_order != '-1' && $order->nebim_order) {
      throw new \Exception("Sipariş daha önce gönderilmiş!.", 404);
    }
    if (!$order_products = get_order_products($order->id)) {
      throw new \Exception("Siparişe ait ürünler bulunamadı!.", 404);
    }
    if (!$buyer = get_user($order->buyer_id)) {
      throw new \Exception("Siparişi satın alan kullanıcı bulunamadı!.", 404);
    }
    $this->__construct();
    $order_shipping = $this->user_address($buyer, get_order_shipping($order->id));
    // products
    $lines = [];
    foreach ($order_products as $key => $order_product) {
      $lines[] = [
        'Qty1'            => $order_product->product_quantity,
        'UsedBarcode'     => $order_product->variation_option_barcodes,
        'ItemTypeCode'    => 1,
        'PriceVI'         => floatval($order_product->product_total_price / 100),
        'LDisRate1'       => 0,
        'SalespersonCode' => 'S000'
      ];
    } // foreach

    // procedure data
    if ($order->payment_method == 'Cash On Delivery') {
      $PaymentTypeCode = $this->payment_settings->cash_nebim_v3;
    } elseif ($order->payment_method == 'Bank Transfer') {
      $PaymentTypeCode = $this->payment_settings->bank_transfer_nebim_v3;
    } else {
      $PaymentTypeCode = get_payment_nebim_code('paynet') ?? 'PayNet';
    }
    $data = [
      'ModelType'     => 6,
      'OrderDate'     => date('Y-m-d H:i'),
      'CustomerCode'  => $buyer->curr_acc_code,
      'OfficeCode'    => $this->v3_office_code,
      'StoreCode'     => $this->v3_store_code,
      'Lines'         => $lines,
      'SumLines'      => [],
      'PosTerminalID' => 900,
      'BillingPostalAddressID'  => $order_shipping->biling_nebim_id,
      'ShippingPostalAddressID' => $order_shipping->shipping_nebim_id,
      'Payments'      => [
        [
          'PaymentType'        => 70,
          'Code'               => $PaymentTypeCode,
          'CurrencyCode'       => $order->price_currency ?? 'TRY',
          'Amount'             => floatval($order->price_total / 100),
        ] // Payments[0]
      ], // Payments Array
      'StoreWareHouseCode' => $this->v3_ware_house,
    ];
    $response = $this->post($data);
    // log
    $this->logs($log_data = [
      'name'     => 'new_order',
      'data'     => json_encode($data),
      'response' => json_encode($response),
      'import'   => $order->id ?? time(),
      'type'     => isset($response['OrderNumber']) ? 'success':'error'
    ]);
    // has error
    if ($err_message = $this->has_error($response)) {
      throw new \Exception($err_message, 500);
    }
    if (isset($order->id)) {
      $this->db->where('id', $order->id);
      $this->db->update('orders', [
        'import_code'  => $order->id ?? $log_data['import'],
        'nebim_order'  => $response['OrderNumber'] ?? '-1'
      ]);
    }
    if (!isset($response['OrderNumber'])) {
      throw new \Exception("OrderNumber kodu bulunumadı!.", 404);
    }
    return $response['OrderNumber'] ?? false;
  }

  public function get_products()
  {
    $this->__construct();
    $response = $this->procedure($this->w3_get_products_procedure);
    $this->logs([
      'name'     => 'get_products',
      'response' => json_encode(is_array($response) ? count($response):strlen($response))
    ]);

    if ($err_message = $this->has_error($response)) {
      throw new \Exception($err_message, 500);
    }

    return $response;
  }

  public function update_products($minute = 5)
  {
    $this->__construct();
    $response = $this->procedure($this->w3_update_products_procedure, $params = [

    ]);
    $this->logs([
      'name'     => 'update_products',
      'data'     => json_encode($params),
      'response' => json_encode(is_array($response) ? count($response):strlen($response))
    ]);

    if ($err_message = $this->has_error($response)) {
      throw new \Exception($err_message, 500);
    }

    return $response;
  }

  public function prefix()
  {
    return '(S(' .  $this->session_id . '))/IntegratorService/';
  }

  public function connect()
  {
    $connect = $this->curl('IntegratorService/Connect');
    if (isset($connect['StatusCode']) && $connect['StatusCode'] == '200') {
       $this->session_id = $connect['SessionID'];
    }
    return $this->session_id;
  }

  public function disconnect()
  {
    $this->curl($this->prefix() . 'Disconnect');
    $this->session_id = null;
  }

  public function procedure($name, $param = [])
  {
    $this->connect();
    $response = $this->curl($this->prefix() . 'RunProc', [
      'ModelType'  => 33,
      'ProcName'   => htmlentities($name),
      'Parameters' => $param
    ]);
    $this->disconnect();
    return $response;
  }

  public function post($data)
  {
    $this->connect();
    $response = $this->curl($this->prefix() . 'POST', $data);
    $this->disconnect();
    return $response;
  }

  private function curl($request, $data = [])
  {
    $url  = $this->api_url . $request;
    $data = json_encode($data);
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Content-Type:application/json'
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($curl);
    if ($curl_error = curl_error($curl)) {
      $this->logs([
        'name'     => 'nebim_curl_' . $request,
        'data'     => is_string($data) ? $data:json_encode($data),
        'response' => is_string($curl_error) ? $curl_error:json_encode($curl_error),
        'type'     => 'error'
      ]);
      throw new \Exception(is_string($curl_error) ? $curl_error:json_encode($curl_error), 500);
    }
    curl_close($curl);

    return json_decode($response, true) ?? [];
  }

  public function image_download($download_url, $filename = null, $extension = 'jpg')
  {
    $st_time = time();
    if (!$filename) {
      $filename = date('YmdHis');
    }
    $filename = 'IMG_' . str_replace(['.jpg', '.jpeg', '.png', '.bmp', '.gif'], '', $filename) . '.' . $extension;

    $curl = curl_init($download_url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $curl_result = curl_exec($curl);

    if ($curl_error = curl_error($curl)) {
      $this->logs([
        'name'     => 'nebim_image',
        'data'     => json_encode(['download_url' => $download_url, 'filename' => $filename]),
        'response' => is_string($curl_error) ? $curl_error:json_encode($curl_error),
        'type'     => 'error',
        'action'   => 'image'
      ]);
      return [
        'status'       => 'error',
        'download_url' => $download_url
      ];
    }

    curl_close($curl);
    chmod($this->path['uploads'], 0757);

    $file_path = $this->path['tmp'] . $filename;
    $ftp_file = fopen($file_path, 'w+');
    fwrite($ftp_file, $curl_result);
    fclose($ftp_file);

    // $diff = intval(time() - $st_time);
    // $this->logs("nebim_images", null, base_url() . 'uploads/images/' . $filename, __FILE__, __LINE__, $diff);

    if (file_exists($file_path) && filesize($file_path) <= 4450) {
      unlink($file_path);
    }

    return [
      'status'       => file_exists($file_path) ? 'success':'error',
      'download_url' => $download_url,
      'filename'     => $filename,
      'filepath'     => $file_path
    ];
  }

  public function logs(array $options)
  {
    /*
     * required name => procedure name | string
     * optional data => procedure sent data | should be string | default:null
     * optional response => procedure received data | should be string | default:null
     * optional import => import code | can be uniq or string or int | default:time()
     * optional type => log type | default:default
     * optional action => request action | default:procedure
     */
     if (!function_exists('nebim_log')) {
       throw new \Exception("nebim_log function not defined", 500);
     }
     if (!isset($options['name'])) {
       return false;
     }
     if (isset($options['data']) && !is_string($options['data'])) {
       $options['data'] = json_encode($options['data']);
     }
     if (isset($options['response']) && !is_string($options['response'])) {
       $options['response'] = json_encode($options['response']);
     }
     $this->load->database();
     $this->db->reconnect();
     return nebim_log()->add([
       'name'     => $options['name'],
       'data'     => $options['data'] ?? null,
       'response' => $options['response'] ?? null,
       'import'   => $options['import'] ?? time(),
       'type'     => $options['type'] ?? 'default',
       'action'   => $options['action'] ?? 'procedure',
     ]);
  }

  public function has_error($response)
  {
    if (isset($response['ExceptionMessage']) == true && $response['ExceptionMessage']) {
      return $response['ExceptionMessage'];
    }

    if ($response = json_encode($response)) {
      $exception = strpos($response, "ExceptionMessage");
      if ($exception !== false) {
        return 'Hata: __LINE__ ' . $exception;
      }
    }

    return null;
  }

  public function truncate()
  {
    return $this->db->truncate($this->table);
  }

}
