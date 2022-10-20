<?php

//coach_schedule_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$output = array();

		if($_SESSION['type'] == 'Admin')
		{
			$order_column = array('coach_table.coach_name', 'coach_schedule_table.coach_schedule_date', 'coach_schedule_table.coach_schedule_day', 'coach_schedule_table.coach_schedule_start_time', 'coach_schedule_table.coach_schedule_end_time', 'coach_schedule_table.average_consulting_time');
			$main_query = "
			SELECT * FROM coach_schedule_table 
			INNER JOIN coach_table 
			ON coach_table.coach_id = coach_schedule_table.coach_id 
			";

			$search_query = '';

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'WHERE coach_table.coach_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_start_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.coach_schedule_end_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_table.average_consulting_time LIKE "%'.$_POST["search"]["value"].'%" ';
			}
		}
		else
		{
			$order_column = array('coach_schedule_date', 'coach_schedule_day', 'coach_schedule_start_time', 'coach_schedule_end_time', 'average_consulting_time');
			$main_query = "
			SELECT * FROM coach_schedule_table 
			";

			$search_query = '
			WHERE coach_id = "'.$_SESSION["admin_id"].'" AND 
			';

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= '(coach_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_start_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR coach_schedule_end_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR average_consulting_time LIKE "%'.$_POST["search"]["value"].'%") ';
			}
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY coach_schedule_table.coach_schedule_id DESC ';
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

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			if($_SESSION['type'] == 'Admin')
			{
				$sub_array[] = html_entity_decode($row["coach_name"]);
			}
			$sub_array[] = $row["coach_schedule_date"];

			$sub_array[] = $row["coach_schedule_day"];

			$sub_array[] = $row["coach_schedule_start_time"];

			$sub_array[] = $row["coach_schedule_end_time"];

			$sub_array[] = $row["average_consulting_time"] . ' Minute';

			$status = '';
			if($row["coach_schedule_status"] == 'Active')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["coach_schedule_id"].'" data-status="'.$row["coach_schedule_status"].'">Active</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["coach_schedule_id"].'" data-status="'.$row["coach_schedule_status"].'">Inactive</button>';
			}

			$sub_array[] = $status;

			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["coach_schedule_id"].'"><i class="fas fa-edit"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["coach_schedule_id"].'"><i class="fas fa-times"></i></button>
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

	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		$coach_id = '';

		if($_SESSION['type'] == 'Admin')
		{
			$coach_id = $_POST["coach_id"];
		}

		if($_SESSION['type'] == 'Coach')
		{
			$coach_id = $_SESSION['admin_id'];
		}

		$data = array(
			':coach_id'					=>	$coach_id,
			':coach_schedule_date'			=>	$_POST["coach_schedule_date"],
			':coach_schedule_day'			=>	date('l', strtotime($_POST["coach_schedule_date"])),
			':coach_schedule_start_time'	=>	$_POST["coach_schedule_start_time"],
			':coach_schedule_end_time'		=>	$_POST["coach_schedule_end_time"],
			':average_consulting_time'		=>	$_POST["average_consulting_time"]
		);

		$object->query = "
		INSERT INTO coach_schedule_table 
		(coach_id, coach_schedule_date, coach_schedule_day, coach_schedule_start_time, coach_schedule_end_time, average_consulting_time) 
		VALUES (:coach_id, :coach_schedule_date, :coach_schedule_day, :coach_schedule_start_time, :coach_schedule_end_time, :average_consulting_time)
		";

		$object->execute($data);

		$success = '<div class="alert alert-success">Planning du Coach ajoutee avec succees</div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM coach_schedule_table 
		WHERE coach_schedule_id = '".$_POST["coach_schedule_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['coach_id'] = $row['coach_id'];
			$data['coach_schedule_date'] = $row['coach_schedule_date'];
			$data['coach_schedule_start_time'] = $row['coach_schedule_start_time'];
			$data['coach_schedule_end_time'] = $row['coach_schedule_end_time'];
			$data['average_consulting_time'] = $row['average_consulting_time'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$coach_id = '';

		if($_SESSION['type'] == 'Admin')
		{
			$coach_id = $_POST["coach_id"];
		}

		if($_SESSION['type'] == 'Coach')
		{
			$coach_id = $_SESSION['admin_id'];
		}

		$data = array(
			':coach_id'					=>	$coach_id,
			':coach_schedule_date'			=>	$_POST["coach_schedule_date"],
			':coach_schedule_start_time'	=>	$_POST["coach_schedule_start_time"],
			':coach_schedule_end_time'		=>	$_POST["coach_schedule_end_time"],
			':average_consulting_time'		=>	$_POST["average_consulting_time"]
		);

		$object->query = "
		UPDATE coach_schedule_table 
		SET coach_id = :coach_id, 
		coach_schedule_date = :coach_schedule_date, 
		coach_schedule_start_time = :coach_schedule_start_time, 
		coach_schedule_end_time = :coach_schedule_end_time, 
		average_consulting_time = :average_consulting_time    
		WHERE coach_schedule_id = '".$_POST['hidden_id']."'
		";

		$object->execute($data);

		$success = '<div class="alert alert-success">Donnees du planning du coach mis a jour</div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':coach_schedule_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE coach_schedule_table 
		SET coach_schedule_status = :coach_schedule_status 
		WHERE coach_schedule_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Status du Planning du coach change a '.$_POST['next_status'].'</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM coach_schedule_table 
		WHERE coach_schedule_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Planning du coach supprime</div>';
	}
}

?>