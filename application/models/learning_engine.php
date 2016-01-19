<?php



class Learning_engine extends CI_Model
{

	

	#Constructor

	function Learning_engine()

	{

		parent::Model();

	}

	

	

	#Function to act like a brain neuron by accepting inputs and based on its training (weights)

	#determine the output

	function learn_rule_neuron($inputs=array())

	{

		$decision = FALSE;

		$output_multiple_sum = 0;

		

		#get the output weight

		foreach($inputs AS $input_code=>$value)

		{

			#Output weight = sum of (input weight x input value)

			$weight_array = $this->Query_reader->get_row_as_array('get_input_weight', array('inputcode'=>$input_code));

			$output_multiple_sum += $weight_array['weight']*$value;

		}

		

		#Only qualify if the sum is greater than or equal to zero

		#REMEMBER: the threshold value is included in the input values

		if($output_multiple_sum >= 0)

		{

			$decision = TRUE;

		}

		

		return array('bool'=>$decision, 'value'=>$output_multiple_sum);

	}

	

	

	

	#Function to update the rule database based on the rule learning

	#THIS FUNCTION IS OBSOLETE. RULES ARE UPDATED ON APPROVAL

	function update_rule_table($rule_details, $status)

	{

		#TODO: Update capturing the region, rule weight

		

		#Get the previous rule for the diagnosis

		$prev_rule_details = $this->Query_reader->get_row_as_array('get_rule_by_stamp', array('stamp'=>$rule_details['ruleused']));

		$combined_symptoms = array_unique(array_merge(explode(',', $prev_rule_details['triggermap']), explode(',', $rule_details['triggers'])));

		$rule_str = $prev_rule_details['rulequery']."|".str_replace(',', '+', $rule_details['triggers']);

		

		#Save based on status

		if($status == 'confirmed' && !empty($rule_details['ruleused']))

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('update_diagnosis_rule', array('rulestamp'=>$rule_details['ruleused'], 'rulequery'=>$rule_str, 'triggermap'=>implode(',', $combined_symptoms) )));

		}

		else

		{

			$result = $this->db->query($this->Query_reader->get_query_by_code('add_diagnosis_rule', array('rulestamp'=>strtotime('now'), 'region'=>'', 'rulequery'=>str_replace(',', '+', $rule_details['triggers']), 'diagnosis'=>$rule_details['correctdiagnosis'], 'triggermap'=>$rule_details['triggers'], 'weight'=>'0.8', 'rulestatus'=>$status)));

		}

		

		

		return $result;

	}

	

	

	#TODO: Add function to update user trust worthiness based on data collected

}

?>