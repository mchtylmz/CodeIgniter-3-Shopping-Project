<?php


class Coupon_modelV1 extends CI_Model
{
	private $table = 'coupons';
	private $pk = 'id';

	//input values
	public function input_values()
	{
		$data = array(
			'code' => case_converter(str_slug($this->input->post('code', true)), 'uppercase'),
			'type' => $this->input->post('type', true),
			'discount' => floatval($this->input->post('discount', true)),
			'status' => $this->input->post('status', true),
			'currency' => $this->input->post('currency', true) ?? $this->default_currency->code,
			'allow_count' => $this->input->post('allow_count', true) ?? 999,
			'start_date' => date('Y-m-d', strtotime($this->input->post('start_date', true))),
			'expire_date' => date('Y-m-d', strtotime($this->input->post('expire_date', true))),
		);
		return $data;
	}

	//add
	public function add()
	{
		$data = $this->input_values();
		$data["created_at"] = date('Y-m-d H:i:s');
		return $this->db->insert($this->table, $data);
	}

	//update
	public function update($id)
	{
			$data = $this->input_values();
			$this->db->where('id', clean_number($id));
			return $this->db->update($this->table, $data);
	}

	//use_increase
	public function use_increase($id, $count)
	{
			$this->db->where('id', clean_number($id));
			return $this->db->update($this->table, ['use_count' => clean_number($count)]);
	}

	public function get_all()
	{
		$this->db->order_by('id', 'DESC')->limit(40);
		$result = $this->db->get($this->table)->result();
		return $result;
	}

	//get
	public function get($id)
	{
		$this->db->where('id', clean_number($id));
		$query = $this->db->get($this->table);
		return $query->row();
	}

	// coupon code
	public function code($code, $currency = null)
	{
		if (!$currency) {
			$currency = $this->default_currency->code;
		}
		$this->db->where('code', clean_str($code));
		$this->db->where('currency', clean_str($currency));
		return $this->db->get($this->table)->row();
	}

	// coupon use
	public function use($code)
	{
		$this->db->where('status', '1');
		$this->db->where('code', clean_str($code));
		$this->db->where('currency', clean_str($this->default_currency->code));
		$this->db->where('start_date <=', date('Y-m-d'));
		// $this->db->where('expire_date >=', date('Y-m-d'));
		return $this->db->get($this->table)->row();
	}

	public function is_available($id)
	{
		if ($coupon = $this->get($id)) {
			return $coupon->use_count < $coupon->allow_count;
		}
		return false;
	}

	//delete
	public function delete($id)
	{
		$id = clean_number($id);
		$coupon = $this->get($id);

		if (!empty($coupon)) {
			$this->db->where('id', $id);
			return $this->db->delete($this->table);
		}
		return false;
	}
}
