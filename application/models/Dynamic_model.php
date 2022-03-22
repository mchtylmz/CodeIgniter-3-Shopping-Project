<?php


class Dynamic_model extends CI_Model
{
	public $table = 'products';
	public $pk = 'id';
	public $created_at = 'created_at';

	//add
	public function add(array $data)
	{
		$data[$this->created_at] = date('Y-m-d H:i:s');
		return $this->db->insert($this->table, $data);
	}

	//update
	public function update(array $data, int $id)
	{
			$this->db->where($this->pk, clean_number($id));
			return $this->db->update($this->table, $data);
	}

	public function get_all()
	{
		$this->db->order_by($this->pk, 'DESC')->limit(100);
		return $this->db->get($this->table)->result();
	}

	//get
	public function get($id)
	{
		$this->db->where($this->pk, clean_number($id));
		return $this->db->get($this->table)->row();
	}

	public function count(array $where = [])
  {
		$this->build_where($where);
    $this->db->order_by($this->pk, 'DESC');
    return $this->db->get($this->table)->num_rows();
  }

  public function paginate($per_page, $offset, array $where = [])
  {
		$this->build_where($where);
    $this->db->order_by($this->pk, 'DESC');
    $this->db->limit($per_page, $offset);
    return $this->db->get($this->table)->result();
  }

	public function build_where(array $where = [])
	{
		if (isset($where['where']) && $where['where']) {
			$this->db->where($where['where']);
		}
		if (isset($where['or_where']) && $where['or_where']) {
			$this->db->group_start();
			$this->db->or_where($where['or_where']);
			$this->db->group_end();
		}
		if (isset($where['like']) && $where['like']) {
			$this->db->group_start();
			$this->db->like($where['like']);
			$this->db->group_end();
		}
		if (isset($where['or_like']) && $where['or_like']) {
			$this->db->group_start();
			$this->db->or_like($where['or_like']);
			$this->db->group_end();
		}
	}

	//delete
	public function delete($id)
	{
		$id = clean_number($id);
		if ($row = $this->get($id)) {
			$this->db->where($this->pk, $id);
			return $this->db->delete($this->table);
		}
		return false;
	}
}
