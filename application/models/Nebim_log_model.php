<?php


class Nebim_log_model extends CI_Model
{
	private $table = 'nebim_log';
	private $pk = 'id';

	public function add(array $data = [])
  {
    if (!$data) return false;
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

	public function generate_query(array $where = [], bool $db = false)
  {
    if (isset($where['where'])) {
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
    $this->db->order_by($this->pk, 'DESC');
    if ($db) {
      return $this->db;
    }
    return $this->db->get($this->table);
  }

	public function get(array $where)
  {
		return $this->generate_query($where)->row();
  }

	public function count(array $where = [])
  {
    return $this->generate_query($where)->num_rows();
  }

  public function paginate($per_page, $offset, array $where = [])
  {
    $paginate_query = $this->generate_query($where, true);
    $paginate_query->limit($per_page, $offset);
    return $paginate_query->get($this->table)->result();
  }

	public function delete(array $where)
  {
		return $this->db->where($where)->delete($this->table);
  }
}
