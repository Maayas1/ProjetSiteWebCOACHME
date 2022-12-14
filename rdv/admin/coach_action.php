<?php

//coach_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('coach_name', 'coach_status');

		$output = array();

		$main_query = "
		SELECT * FROM coach_table ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE coach_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR coach_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR coach_phone_no LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR coach_date_of_birth LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR coach_degree LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR coach_expert_in LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR coach_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY coach_id DESC ';
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
			$sub_array[] = '<img src="'.$row["coach_profile_image"].'" class="img-thumbnail" width="75" />';
			$sub_array[] = $row["coach_email_address"];
			$sub_array[] = $row["coach_password"];
			$sub_array[] = $row["coach_name"];
			$sub_array[] = $row["coach_phone_no"];
			$sub_array[] = $row["coach_expert_in"];
			$status = '';
			if($row["coach_status"] == 'Active')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["coach_id"].'" data-status="'.$row["coach_status"].'">Active</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["coach_id"].'" data-status="'.$row["coach_status"].'">Inactive</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-circle btn-sm view_button" data-id="'.$row["coach_id"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["coach_id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["coach_id"].'"><i class="fas fa-times"></i></button>
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

		$data = array(
			':coach_email_address'	=>	$_POST["coach_email_address"]
		);

		$object->query = "
		SELECT * FROM coach_table 
		WHERE coach_email_address = :coach_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$coach_profile_image = '';
			if($_FILES['coach_profile_image']['name'] != '')
			{
				$allowed_file_format = array("jpg", "png");

	    		$file_extension = pathinfo($_FILES["coach_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
			    }
			    else if (($_FILES["coach_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['coach_profile_image']['tmp_name'], $destination);

					$coach_profile_image = $destination;
			    }
			}
			else
			{
				$character = $_POST["coach_name"][0];
				$path = "../images/". time() . ".png";
				$image = imagecreate(200, 200);
				$red = rand(0, 255);
				$green = rand(0, 255);
				$blue = rand(0, 255);
			    imagecolorallocate($image, 230, 230, 230);  
			    $textcolor = imagecolorallocate($image, $red, $green, $blue);
			    imagettftext($image, 100, 0, 55, 150, $textcolor, '../font/arial.ttf', $character);
			    imagepng($image, $path);
			    imagedestroy($image);
			    $coach_profile_image = $path;
			}

			if($error == '')
			{
				$data = array(
					':coach_email_address'			=>	$object->clean_input($_POST["coach_email_address"]),
					':coach_password'				=>	$_POST["coach_password"],
					':coach_name'					=>	$object->clean_input($_POST["coach_name"]),
					':coach_profile_image'			=>	$coach_profile_image,
					':coach_phone_no'				=>	$object->clean_input($_POST["coach_phone_no"]),
					':coach_address'				=>	$object->clean_input($_POST["coach_address"]),
					':coach_date_of_birth'			=>	$object->clean_input($_POST["coach_date_of_birth"]),
					':coach_degree'				=>	$object->clean_input($_POST["coach_degree"]),
					':coach_expert_in'				=>	$object->clean_input($_POST["coach_expert_in"]),
					':coach_status'				=>	'Active',
					':coach_added_on'				=>	$object->now
				);

				$object->query = "
				INSERT INTO coach_table 
				(coach_email_address, coach_password, coach_name, coach_profile_image, coach_phone_no, coach_address, coach_date_of_birth, coach_degree, coach_expert_in, coach_status, coach_added_on) 
				VALUES (:coach_email_address, :coach_password, :coach_name, :coach_profile_image, :coach_phone_no, :coach_address, :coach_date_of_birth, :coach_degree, :coach_expert_in, :coach_status, :coach_added_on)
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">coach Added</div>';
			}
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM coach_table 
		WHERE coach_id = '".$_POST["coach_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['coach_email_address'] = $row['coach_email_address'];
			$data['coach_password'] = $row['coach_password'];
			$data['coach_name'] = $row['coach_name'];
			$data['coach_profile_image'] = $row['coach_profile_image'];
			$data['coach_phone_no'] = $row['coach_phone_no'];
			$data['coach_address'] = $row['coach_address'];
			$data['coach_date_of_birth'] = $row['coach_date_of_birth'];
			$data['coach_degree'] = $row['coach_degree'];
			$data['coach_expert_in'] = $row['coach_expert_in'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':coach_email_address'	=>	$_POST["coach_email_address"],
			':coach_id'			=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM coach_table 
		WHERE coach_email_address = :coach_email_address 
		AND coach_id != :coach_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$coach_profile_image = $_POST["hidden_coach_profile_image"];

			if($_FILES['coach_profile_image']['name'] != '')
			{
				$allowed_file_format = array("jpg", "png");

	    		$file_extension = pathinfo($_FILES["coach_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
			    }
			    else if (($_FILES["coach_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['coach_profile_image']['tmp_name'], $destination);

					$coach_profile_image = $destination;
			    }
			}

			if($error == '')
			{
				$data = array(
					':coach_email_address'			=>	$object->clean_input($_POST["coach_email_address"]),
					':coach_password'				=>	$_POST["coach_password"],
					':coach_name'					=>	$object->clean_input($_POST["coach_name"]),
					':coach_profile_image'			=>	$coach_profile_image,
					':coach_phone_no'				=>	$object->clean_input($_POST["coach_phone_no"]),
					':coach_address'				=>	$object->clean_input($_POST["coach_address"]),
					':coach_date_of_birth'			=>	$object->clean_input($_POST["coach_date_of_birth"]),
					':coach_degree'				=>	$object->clean_input($_POST["coach_degree"]),
					':coach_expert_in'				=>	$object->clean_input($_POST["coach_expert_in"])
				);

				$object->query = "
				UPDATE coach_table  
				SET coach_email_address = :coach_email_address, 
				coach_password = :coach_password, 
				coach_name = :coach_name, 
				coach_profile_image = :coach_profile_image, 
				coach_phone_no = :coach_phone_no, 
				coach_address = :coach_address, 
				coach_date_of_birth = :coach_date_of_birth, 
				coach_degree = :coach_degree,  
				coach_expert_in = :coach_expert_in 
				WHERE coach_id = '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Donnees du coach mis a jour</div>';
			}			
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':coach_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE coach_table 
		SET coach_status = :coach_status 
		WHERE coach_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Class Status change to '.$_POST['next_status'].'</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM coach_table 
		WHERE coach_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Donnees du coach supprimees</div>';
	}
}

?>