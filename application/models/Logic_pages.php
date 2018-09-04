<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * page & category logic
 */
class Logic_pages extends CI_Model {
    /**
     * Get page categories
     */
    public function getCategories()
    {
        $query = $this->db->query("SELECT * FROM dtb_page_categories WHERE status = 1 ORDER BY category_id ASC");

        $models = array();
        foreach( $query->result_array() as $model ){
            $models[$model['category_id']] = array(
				'name' => $model['name'],
				'class' => $model['class']
			);
        }
        
        return $models;
    }
	
	/**
     * Get all pages
     */
    public function getAllPages()
    {
        $query = $this->db->query("SELECT * FROM dtb_pages WHERE status = 1 ORDER BY category_id ASC, bit ASC");

        $models = array();
        foreach( $query->result() as $model ){
            $models[$model->category_id][$model->bit] = array(
				'name' => $model->name,
				'link' => $model->link
			);
        }
        
        return $models;
    }
}