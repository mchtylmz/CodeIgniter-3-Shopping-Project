<?php


class Cargo_model extends CI_Model
{
	private $api_url = 'https://kurye.airtechkibris.com/kuryeapi/';
	private $username = '';
	private $password = '';
	private $sender = [];

	public function __construct()
  {
      parent::__construct();
			if ($general_settings = get_general_settings()) {
        $this->api_url  = $general_settings->cargo_api_url;
        $this->username = $general_settings->cargo_username;
        $this->password = $general_settings->cargo_password;
        $this->sender = [
					'name'    => $general_settings->cargo_sender_name,
					'address' => $general_settings->cargo_sender_address,
					'city'    => $general_settings->cargo_sender_city,
					'tel'     => $general_settings->cargo_sender_tel,
				];
      }
  }

	/*
	 * Müşterinin kendi adına açılmış partileri listelemesi
	 * response
		 {
				"101": "Normal Dağıtım",
				"102": "Tahsilatlı Dağıtım",
				"103": "Hızlı Dağıtım",
				"104": "Adresten Paket Teslimatı",
				"105": "Mesafe/Boyut Teslimatı"
			}

		* Müşterinin parti içindeki tüm gönderileri listelemesi
		* Param $type_code 101 - 105
		* Response
			[
				"B0001",
				"B0002",
				"B0003"
			]

		* Müşterinin gönderi bilgisini alması
		* Param
			$type_code 101 - 105
			$cargo_code exp B0001
		* Response
			{
				"sender":{
					"name":"X Firma",
					"address":"Gonyeli",
					"city":"1",
					"tel":"1234567",
				},
				"receiver":
				{
					"name":"Ornek Musteri",
					"address":"Y.Kent",
					"city":"1",
					"tel":"533888888",
					"mobile":"05331234567"
				},
				"status":
				{
					"code":"01",
					"message":"Musteriden alindi"
				}
			}

	 */
	public function lots($type_code = null, $cargo_code = null)
	{
		try {
			$url = 'lots';
			if ($type_code) {
				$url = $url . '/' . $type_code;
			}
			if ($cargo_code) {
				$url = $url . '/' . $cargo_code;
			}
			return $this->curl($url, [], 'GET');
		} catch (\Exception $err) {
			throw new \Exception($err->getMessage(), 404);
		}
	}

	/*
	 * Müşterinin partiye yeni gönderi eklemesi
	 * Param lot number, lot data
	 * response
		 {
				"code":"201",
				"barcode":"B0001"
			}
		*/
	public function lots_save($lot, array $data)
	{
		try {
			$params = [
				'lot'    => $lot,
				'sender' => $this->sender,
				'receiver' => [
					'name'    => $data['name'] ?? '',
					'address' => $data['address'] ?? '',
					'city'    => $data['city'] ?? '',
					'tel'     => $data['tel'] ?? '',
					'mobile'  => $data['tel'] ?? '',
				],
				/*
				'payment'  => [
					'amount' => ''
				]
				*/
			];
			return $this->curl('lots', $params, 'POST');
		} catch (\Exception $err) {
			throw new \Exception($err->getMessage(), 404);
		}
	}

	public function user_hash($request, $method, $gmdate, $post_data = null)
	{
		$data = $request . $method;
		if ($request == 'POST') {
			$data = $data . $post_data;
		}
		$data = $data . str_replace(' ', '', $gmdate);
		$hash = hash_hmac('sha256', $data, $this->password, false);
		return $this->username .':'. base64_encode($hash);
	}

	public function gmdate()
	{
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('GMT'));
		return $date->format('D, j M Y H:i:s \G\M\T');
	}

	private function curl($method, $data = [], $request = 'GET')
  {
    $curl = curl_init($this->api_url . $method);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if ($request == 'POST') {
			$data = json_encode($data);
    	curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		$gmdate = $this->gmdate();
		$user_hash = $this->user_hash($request, $method, $gmdate, ($request == 'POST' ? $data:''));
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Content-Type:application/json',
			'Authorization: ' . $user_hash,
			'Date: ' . $gmdate
    ]);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($curl);
		$logs_data = [
			 'url'      => $method,
			 'data'     => is_string($data) ? $data:json_encode($data),
			 'request'  => $request,
			 'header'   => json_encode([
				 'Authorization: ' . $user_hash,
				 'Date: ' . $gmdate
			 ])
		];

    if ($curl_error = curl_error($curl)) {
			$this->logs(array_merge($logs_data, [
				'status'   => 'error',
				'response' => is_string($curl_error) ? $curl_error:json_encode($curl_error)
			]));
      throw new \Exception(is_string($curl_error) ? $curl_error:json_encode($curl_error), 500);
    }
    curl_close($curl);

		$this->logs(array_merge($logs_data, [
			'status'   => 'success',
			'response' => is_string($response) ? $response:json_encode($response)
		]));
    return json_decode($response, true) ?? [];
  }

	public function logs(array $data)
	{
		$insert = [
			'status'  => $data['status'] ?? 'error',
			'url'     => $data['url'] ?? 'index',
			'data'    => $data['data'] ?? null,
			'request' => $data['request'] ?? 'GET',
			'response'=> $data['response'] ?? null,
			'header'  => $data['header'] ?? null
		];
		// TODO: logs
		// $this->db->insert('cargo_logs', $insert);
	}

}
