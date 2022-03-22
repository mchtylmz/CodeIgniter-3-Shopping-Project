<?php


class Onesignal_model extends CI_Model
{
	const SEND_ENDPOINT_URL = 'https://onesignal.com/api/v1/notifications';
	const VIEW_ENDPOINT_URL = 'https://onesignal.com/api/v1/notifications';

	private $app_id = '';
	private $rest_api_key = '';
	private $admin_player_ids = [];
	private $contents = [];
	private $fields = [];
	private $errors = null;

	public function __construct()
  {
      parent::__construct();
      if ($general_settings = get_general_settings()) {
        $this->app_id = $general_settings->onesignal_app_id;
	      $this->rest_api_key = $general_settings->onesignal_key;
				$this->admin_player_ids = explode(',', $general_settings->onesignal_player_id) ?? [];
      }
  }

	public function message($message, $lang = 'en')
	{
		if (!is_string($message)) {
			$message = json_encode($message);
		}
		$this->contents[$lang] = $message;
		return $this;
	}

	public function url($url)
	{
		$this->fields['web_url'] = $url;
		$this->fields['app_url'] = $url;
		return $this;
	}

	public function filter(array $filter)
	{
		$this->contents['filter'][] = $filter;
		return $this;
	}

	public function data($key, $value = '')
	{
		$this->contents['data'][$key] = $value;
		return $this;
	}

	public function player_id($player_id)
	{
		if (!is_string($player_id)) {
			return $this;
		}
		if (isset($this->fields['included_segments'])) {
			unset($this->fields['included_segments']);
		}
		$this->fields['include_player_ids'][] = trim($player_id);
		return $this;
	}

	public function player_ids(array $player_ids = [])
	{
		foreach ($player_ids as $key => $player_id) {
			$this->player_id($player_id);
		}
		return $this;
	}

	public function segment($segment = 'All')
	{
		if (isset($this->fields['include_player_ids'])) {
			unset($this->fields['include_player_ids']);
		}
		$this->fields['included_segments'] = [$segment];
		return $this;
	}

	public function send()
	{
		return $this->curl(self::SEND_ENDPOINT_URL);
	}

	public function admins($message, $url = '/')
	{
		if ($this->admin_player_ids) {
			return $this->message($message)->url(base_url() . $url)->player_ids($this->admin_player_ids)->send();
		}
		return false;
	}

	public function notifications($limit = 10, $offset = 0)
	{
		$url = self::VIEW_ENDPOINT_URL . "?app_id={$this->app_id}&limit={$limit}&offset={$offset}";
		return $this->curl($url, [
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => 'CURL_HTTP_VERSION_1_1',
			CURLOPT_CUSTOMREQUEST => 'GET'
		]);
	}

	public function errors()
	{
		return $this->errors;
	}

	public function config($app_id, $rest_api_key, $admin_player_ids = null)
	{
		$this->app_id = $general_settings->onesignal_app_id;
		$this->rest_api_key = $general_settings->onesignal_key;
		if ($admin_player_ids) {
			$this->admin_player_ids = is_array($admin_player_ids) ? $admin_player_ids : explode(',', $admin_player_ids);
		}
	}

	/*
	 * PRIVATE
	 */

	private function curl($endpoint, $options = [])
	{
			$curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, $endpoint);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json; charset=utf-8', 'Authorization: Basic ' . $this->rest_api_key
			));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($curl, CURLOPT_HEADER, FALSE);

			if (get_general_settings()->onesignal_test_mode ?? false) {
				$this->fields['include_player_ids'] = ['8a1216da-0ec0-4363-b21f-54e36d045680'];
				if (isset($this->fields['included_segments'])) {
					unset($this->fields['included_segments']);
				}
			}

			if ($this->fields) {
				$this->fields['app_id'] = $this->app_id;
				$this->fields['contents'] = $this->contents;
				curl_setopt($curl, CURLOPT_POST, TRUE);
	      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->fields));
			}

			if (is_array($options) && $options) {
				curl_setopt_array($curl, $options);
			}

      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response = curl_exec($curl);

			if (curl_error($curl)) {
				$this->errors = curl_error($curl);
	      return false;
	    }

      curl_close($curl);

			$response = json_decode($response, true) ?? false;;
			if (isset($response['errors'])) {
				$this->errors = $response['errors'];
	      return false;
	    }

      return $response;
	}

}
