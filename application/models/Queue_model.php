<?php
set_time_limit(0);

/*
 * 1 => waiting
 * 2 => processing
 * 3 => complete
 * 4 => failed
 * 5 => pass
 */
class Queue_model extends CI_Model
{
  private $table = 'nebim_queue';
  private $pk = 'id';

	public function add(array $data = [])
  {
    if (!$data) return false;
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

	public function update(array $data = [], array $where = [])
  {
		if (!$where) return false;
    return $this->db->where($where)->update($this->table, $data);
  }

  public function update_by_id(array $data, int $id)
  {
		return $this->update($data, [$this->pk => $id]);
  }

	public function generate_query(array $where = [], bool $db = false)
  {
    if ($where) $this->db->where($where);
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

  public function get_all(array $where)
  {
		return $this->generate_query($where)->result();
  }

	public function run(array $where = [], int $limit = 1)
  {
    // limit
    $this->db->limit($limit);
    // order
    $this->db->order_by('status', 'ASC');
    $this->db->order_by('attempt', 'ASC');
    $this->db->order_by('id', 'ASC');
    // where
    $this->db->where('attempt <=', 5);
		$this->db->where_in('status', [1, 2]);
    if ($where) {
      $this->db->where($where);
    }
    return $this->db->get($this->table)->result();
  }

  public function method($method, int $limit = 1)
  {
    return $this->run(['method' => $method], $limit);
  }

  public function filter_query(array $where = [])
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

	public function count(array $where = [])
  {
    $this->filter_query($where);
    $this->db->order_by($this->pk, 'DESC');
    return $this->db->get($this->table)->num_rows();
  }

  public function paginate($per_page, $offset, array $where = [])
  {
    $this->filter_query($where);
    $this->db->order_by($this->pk, 'DESC');
    $this->db->limit($per_page, $offset);
    return $this->db->get($this->table)->result();
  }

	public function delete(array $where)
  {
		return $this->db->where($where)->delete($this->table);
  }

	public function delete_archive(int $days = 45)
	{
		$archive_date = date("Y-m-d H:i:s", strtotime("- $days days"));
    $this->db->where('updated_at <=', $archive_date);
    return $this->db->delete($this->table);
	}

  public function truncate()
  {
    return $this->db->truncate($this->table);
  }

}

/*****
CREATE TABLE `nebim_queue` (
  `id` int(11) NOT NULL,
  `method` varchar(60) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT 'index',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `attempt` int(2) DEFAULT 0,
  `status` enum( '1', '2', '3', '4') COLLATE utf8mb4_turkish_ci DEFAULT '1',
  `failed_msg` text COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `worked_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

ALTER TABLE `nebim_queue`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `nebim_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
******/
