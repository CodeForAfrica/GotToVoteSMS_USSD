<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_functions extends CI_Model {
		
		
		public function dblog($message, $number, $newscreen){
			//check if there is active session
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			$total = $query->num_rows();
			
				
			if($total>0){
			$query = $query->result_array();
			$query = $query[0];
			//check session level	
				$level = $query['sess_level'];
				//update screen level
				$this->db->query("update sessions set sess_current_screen='$newscreen' where sess_number='$number'");			
			}else{
			//start new session
				$this->db->query("insert into sessions(sess_number, sess_level, sess_current_screen, sess_started)values('$number', '1', '1', now())");				
			}
		}
		public function get_level($number){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			$level = $query['sess_level'];
			return $level;	
		}
		public function lower_level($number){
			$this->db->query("update sessions set sess_level=sess_level-1 where sess_number='$number'");
			
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			$level = $query['sess_level'];
			return $level;	
		}
		public function update_level($level, $number){
			$this->db->query("update sessions set sess_level='$level' where sess_number='$number'");
		}
		public function get_screen($number){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			$screen = $query['sess_current_screen'];
			return $screen;	
		}
		public function last_ward($number){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			return $query['sess_last_ward'];
		}
		public function last_const($number){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			return $query['sess_last_const'];
		}
		public function get_id($number, $code){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			$result = $query['sess_option_ids'];
			$code = $code-1;
			$result = explode(",", $result);
			return $result[$code];
		}
		public function last_county($number){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			return $query['sess_last_county'];
		}
		public function get_sess_id($number){
			$this->db->select("*");
			$this->db->from("sessions");
			$this->db->where("sess_number", $number);
			$query = $this->db->get();
			
			$query = $query->result_array();
			$query = $query[0];	
			return $query['sess_id'];
		}
		public function set_option_ids($number, $option_ids){
			$options = implode(",", $option_ids);
			
			$id = $this->get_sess_id($number);
			
			$query = "update sessions set sess_option_ids='$options' where sess_id='$id'";
								
			$this->db->query($query);
		
		}
}
?>
