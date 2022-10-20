<?php

//appointment_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$output = array();

		if($_SESSION['type'] == 'Admin')
		{
			$order_column = array('appointment_table.appointment_number', 'client_table.client_first_name', 'coach_table.coach_name', 'coach_schedule_table.coach_schedule_date', 'appointment_table.appointment_time', 'coach_schedule_table.coach_schedule_day', 'appointment_table.status');
			$main_query = "
			SELECT * FROM appointment_table  
			INNER JOIN coach_table 
			ON coach_table.coach_id = appointment_table.coach_id 
			INNER JOIN coach_schedule_table 
			ON coach_schedule_table.coach_schedule_id = appointment_table.coach_schedule_id 
			INNER JOIN client_table 
			ON client_table.client_id = appointment_table.client_id 
			";

			$search_query = '';

			if($_POST["is_date_search"] == "yes")
			{
			 	$search_query .= 'WHERE coach_schedule_table.coach_schedule_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND (';
			}
			else
			{
				$search_query .= 'WHERE ';
			}

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR client_table.client_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR client_table.client_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_table.coach_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if($_POST["is_date_search"] == "yes")
			{
				$search_query .= ') ';
			}
			else
			{
				$search_query .= '';
			}
		}
		else
		{
			$order_column = array('appointment_table.appointment_number', 'client_table.client_first_name', 'coach_schedule_table.coach_schedule_date', 'appointment_table.appointment_time', 'coach_schedule_table.coach_schedule_day', 'appointment_table.status');

			$main_query = "
			SELECT * FROM appointment_table 
			INNER JOIN coach_schedule_table 
			ON coach_schedule_table.coach_schedule_id = appointment_table.coach_schedule_id 
			INNER JOIN client_table 
			ON client_table.client_id = appointment_table.client_id 
			";

			$search_query = '
			WHERE appointment_table.coach_id = "'.$_SESSION["admin_id"].'" 
			';

			if($_POST["is_date_search"] == "yes")
			{
			 	$search_query .= 'AND coach_schedule_table.coach_schedule_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" ';
			}
			else
			{
				$search_query .= '';
			}

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'AND (appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR client_table.client_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR client_table.client_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%") ';
			}
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY appointment_table.appointment_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["appointment_number"];

			$sub_array[] = $row["client_first_name"] . ' ' . $row["client_last_name"];

			if($_SESSION['type'] == 'Admin')
			{
				$sub_array[] = $row["coach_name"];
			}
			$sub_array[] = $row["coach_schedule_date"];

			$sub_array[] = $row["appointment_time"];

			$sub_array[] = $row["coach_schedule_day"];

			$status = '';

			if($row["status"] == 'Booked')
			{
				$status = '<span class="badge badge-warning">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'In Process')
			{
				$status = '<span class="badge badge-primary">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Completed')
			{
				$status = '<span class="badge badge-success">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Cancel')
			{
				$status = '<span class="badge badge-danger">' . $row["status"] . '</span>';
			}

			$sub_array[] = $status;

			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-circle btn-sm view_button" data-id="'.$row["appointment_id"].'"><i class="fas fa-eye"></i></button>
			</div>
			';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM appointment_table 
		WHERE appointment_id = '".$_POST["appointment_id"]."'
		";

		$appointment_data = $object->get_result();

		foreach($appointment_data as $appointment_row)
		{

			$object->query = "
			SELECT * FROM client_table 
			WHERE client_id = '".$appointment_row["client_id"]."'
			";

			$client_data = $object->get_result();

			$object->query = "
			SELECT * FROM coach_schedule_table 
			INNER JOIN coach_table 
			ON coach_table.coach_id = coach_schedule_table.coach_id 
			WHERE coach_schedule_table.coach_schedule_id = '".$appointment_row["coach_schedule_id"]."'
			";

			$coach_schedule_data = $object->get_result();

			$html = '
			<h4 class="text-center">Details du Client</h4>
			<table class="table">
			';

			foreach($client_data as $client_row)
			{
				$html .= '
				<tr>
					<th width="40%" class="text-right">Nom du Client</th>
					<td>'.$client_row["client_first_name"].' '.$client_row["client_last_name"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Numero de telephone</th>
					<td>'.$client_row["client_phone_no"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Addresse</th>
					<td>'.$client_row["client_address"].'</td>
				</tr>
				';
			}

			$html .= '
			</table>
			<hr />
			<h4 class="text-center">Appointment Details</h4>
			<table class="table">
				<tr>
					<th width="40%" class="text-right">Numero de RDV</th>
					<td>'.$appointment_row["appointment_number"].'</td>
				</tr>
			';
			foreach($coach_schedule_data as $coach_schedule_row)
			{
				$html .= '
				<tr>
					<th width="40%" class="text-right">Nom du Coach</th>
					<td>'.$coach_schedule_row["coach_name"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Date du RDV</th>
					<td>'.$coach_schedule_row["coach_schedule_date"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Jour du RDV</th>
					<td>'.$coach_schedule_row["coach_schedule_day"].'</td>
				</tr>
				
				';
			}

			$html .= '
				<tr>
					<th width="40%" class="text-right">Heure de RDV</th>
					<td>'.$appointment_row["appointment_time"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Raison du RDV</th>
					<td>'.$appointment_row["reason_for_appointment"].'</td>
				</tr>
			';

			if($appointment_row["status"] != 'Cancel')
			{
				if($_SESSION['type'] == 'Admin')
				{
					if($appointment_row['client_come_into_sallesport'] == 'Yes')
					{
						if($appointment_row["status"] == 'Completed')
						{
							$html .= '
								<tr>
									<th width="40%" class="text-right">Client vient a la salle de sport</th>
									<td>Yes</td>
								</tr>
								<tr>
									<th width="40%" class="text-right">Commentaire du Coach</th>
									<td>'.$appointment_row["coach_comment"].'</td>
								</tr>
							';
						}
						else
						{
							$html .= '
								<tr>
									<th width="40%" class="text-right">Client vient a la salle de sport</th>
									<td>
										<select name="client_come_into_sallesport" id="client_come_into_sallesport" class="form-control" required>
											<option value="">Select</option>
											<option value="Yes" selected>Yes</option>
										</select>
									</td>
								</tr
							';
						}
					}
					else
					{
						$html .= '
							<tr>
								<th width="40%" class="text-right">Client vient a la salle de sport</th>
								<td>
									<select name="client_come_into_sallesport" id="client_come_into_sallesport" class="form-control" required>
										<option value="">Select</option>
										<option value="Yes">Yes</option>
									</select>
								</td>
							</tr
						';
					}
				}

				if($_SESSION['type'] == 'Coach')
				{
					if($appointment_row["client_come_into_sallesport"] == 'Yes')
					{
						if($appointment_row["status"] == 'Completed')
						{
							$html .= '
								<tr>
									<th width="40%" class="text-right">Commentaire du Coach</th>
									<td>
										<textarea name="coach_comment" id="coach_comment" class="form-control" rows="8" required>'.$appointment_row["coach_comment"].'</textarea>
									</td>
								</tr
							';
						}
						else
						{
							$html .= '
								<tr>
									<th width="40%" class="text-right">Commentaire du Coach</th>
									<td>
										<textarea name="coach_comment" id="coach_comment" class="form-control" rows="8" required></textarea>
									</td>
								</tr
							';
						}
					}
				}
			
			}

			$html .= '
			</table>
			';
		}

		echo $html;
	}

	if($_POST['action'] == 'change_appointment_status')
	{
		if($_SESSION['type'] == 'Admin')
		{
			$data = array(
				':status'							=>	'In Process',
				':client_come_into_sallesport'		=>	'Yes',
				':appointment_id'					=>	$_POST['hidden_appointment_id']
			);

			$object->query = "
			UPDATE appointment_table 
			SET status = :status, 
			client_come_into_sallesport = :client_come_into_sallesport 
			WHERE appointment_id = :appointment_id
			";

			$object->execute($data);

			echo '<div class="alert alert-success">Appointment Status change to In Process</div>';
		}

		if($_SESSION['type'] == 'Coach')
		{
			if(isset($_POST['coach_comment']))
			{
				$data = array(
					':status'							=>	'Completed',
					':coach_comment'					=>	$_POST['coach_comment'],
					':appointment_id'					=>	$_POST['hidden_appointment_id']
				);

				$object->query = "
				UPDATE appointment_table 
				SET status = :status, 
				coach_comment = :coach_comment 
				WHERE appointment_id = :appointment_id
				";

				$object->execute($data);

				echo '<div class="alert alert-success">Appointment Completed</div>';
			}
		}
	}
	

	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM coach_schedule_table 
		WHERE coach_schedule_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Planning du Coach a ete supprime</div>';
	}
}

?>