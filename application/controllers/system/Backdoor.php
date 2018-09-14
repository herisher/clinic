<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Backdoor extends MY_Controller {

    public function materialstock_action()
    {
        echo "Backdoor for material stock. Be carefull!<br />";
        
        $purchase = $this->db->query(
        "SELECT * FROM dtb_material_purchase_detail ORDER BY material_purchase_id ASC"
        )->result_array();
        
        foreach( $purchase as $detail ){
            //insert into stock material history
            $history = array(
                'material_id'		    => $detail['material_id'],
                'material_weight'	    => $detail['material_weight'],
                'roll_amount'           => $detail['roll_amount'],
                'refs'                  => "material purchase id " . $detail['material_purchase_id'],
            );
            $this->db->insert("dtb_stock_material_history", $history);
        }
        
        $reduction = $this->db->query(
        "SELECT * FROM dtb_material_reduction ORDER BY material_reduction_id ASC"
        )->result_array();
        
        foreach( $reduction as $detail ) {
            //insert into stock material history
            $history = array(
                'material_id'		    => $detail['material_id'],
                'material_weight'	    => '-'.$detail['material_weight'],
                'roll_amount'           => '-'.$detail['roll_amount'],
                'refs'                  => "material reduction id " . $detail['material_reduction_id'],
            );
            $this->db->insert("dtb_stock_material_history", $history);
        }
    }
    
}