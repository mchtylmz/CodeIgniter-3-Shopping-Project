<?php


class Story_model extends CI_Model
{
    //add item
    public function add_item()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'link' => $this->input->post('link', true),
            'item_order' => $this->input->post('item_order', true),
            'status' => $this->input->post('status', true) == '1' ? 1:0
        );

        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            $data["image"] = $this->upload_model->story_image_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        }
        $temp_path = $this->upload_model->upload_temp_image('file_avatar');
        if (!empty($temp_path)) {
            $data["avatar"] = $this->upload_model->story_avatar_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        }
        return $this->db->insert('story', $data);
    }

    //update item
    public function update_item($id)
    {
        $data = array(
          'lang_id' => $this->input->post('lang_id', true),
          'title' => $this->input->post('title', true),
          'link' => $this->input->post('link', true),
          'item_order' => $this->input->post('item_order', true),
          'status' => $this->input->post('status', true) == '1' ? 1:0
        );

        $item = $this->get_story_item($id);
        if (!empty($item)) {
            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file');
            if (!empty($temp_path)) {
                delete_file_from_server($item->image);
                $data["image"] = $this->upload_model->story_image_upload($temp_path);
                $this->upload_model->delete_temp_image($temp_path);
            }
            $temp_path = $this->upload_model->upload_temp_image('file_avatar');
            if (!empty($temp_path)) {
                $data["avatar"] = $this->upload_model->story_avatar_upload($temp_path);
                $this->upload_model->delete_temp_image($temp_path);
            }

            $this->db->where('id', $id);
            return $this->db->update('story', $data);
        }
        return false;
    }

    //get story item
    public function get_story_item($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('story');
        return $query->row();
    }

    //get story items
    public function get_story_items()
    {
        $this->db->where('lang_id', $this->selected_lang->id);
        $this->db->order_by('item_order');
        $query = $this->db->get('story');
        return $query->result();
    }

    //active_items
    public function active_items($limit = 10)
    {
        $this->db->where('lang_id', $this->selected_lang->id);
        $this->db->order_by('item_order');
        $this->db->limit($limit);
        $query = $this->db->get('story');
        return $query->result();
    }

    //get all story items
    public function get_story_items_all()
    {
        $this->db->order_by('item_order');
        $query = $this->db->get('story');
        return $query->result();
    }

    //delete slider item
    public function delete_story_item($id)
    {
        $id = clean_number($id);
        $story_item = $this->get_story_item($id);
        if (!empty($story_item)) {
            delete_file_from_server($story_item->image);
            delete_file_from_server($story_item->avatar);
            $this->db->where('id', $id);
            return $this->db->delete('story');
        }
        return false;
    }

}
