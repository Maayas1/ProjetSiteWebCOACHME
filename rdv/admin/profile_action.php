<?php

include('../class/Appointment.php');

$object = new Appointment;

if($_POST["action"] == 'coach_profile')
{
	sleep(2);

	$error = '';

	$success = '';

	$coach_profile_image = '';

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

			$success = '<div class="alert alert-success">Donnees du Coach mis a jour</div>';
		}			
	}

	$output = array(
		'error'					=>	$error,
		'success'				=>	$success,
		'coach_email_address'	=>	$_POST["coach_email_address"],
		'coach_password'		=>	$_POST["coach_password"],
		'coach_name'			=>	$_POST["coach_name"],
		'coach_profile_image'	=>	$coach_profile_image,
		'coach_phone_no'		=>	$_POST["coach_phone_no"],
		'coach_address'		=>	$_POST["coach_address"],
		'coach_date_of_birth'	=>	$_POST["coach_date_of_birth"],
		'coach_degree'			=>	$_POST["coach_degree"],
		'coach_expert_in'		=>	$_POST["coach_expert_in"],
	);

	echo json_encode($output);
}

if($_POST["action"] == 'admin_profile')
{
	sleep(2);

	$error = '';

	$success = '';

	$sallesport_logo = $_POST['hidden_sallesport_logo'];

	if($_FILES['sallesport_logo']['name'] != '')
	{
		$allowed_file_format = array("jpg", "png");

	    $file_extension = pathinfo($_FILES["sallesport_logo"]["name"], PATHINFO_EXTENSION);

	    if(!in_array($file_extension, $allowed_file_format))
		{
		    $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
		}
		else if (($_FILES["sallesport_logo"]["size"] > 2000000))
		{
		   $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
	    }
		else
		{
		    $new_name = rand() . '.' . $file_extension;

			$destination = '../images/' . $new_name;

			move_uploaded_file($_FILES['sallesport_logo']['tmp_name'], $destination);

			$sallesport_logo = $destination;
		}
	}

	if($error == '')
	{
		$data = array(
			':admin_email_address'			=>	$object->clean_input($_POST["admin_email_address"]),
			':admin_password'				=>	$_POST["admin_password"],
			':admin_name'					=>	$object->clean_input($_POST["admin_name"]),
			':sallesport_name'				=>	$object->clean_input($_POST["sallesport_name"]),
			':sallesport_address'				=>	$object->clean_input($_POST["sallesport_address"]),
			':sallesport_contact_no'			=>	$object->clean_input($_POST["sallesport_contact_no"]),
			':sallesport_logo'				=>	$sallesport_logo
		);

		$object->query = "
		UPDATE admin_table  
		SET admin_email_address = :admin_email_address, 
		admin_password = :admin_password, 
		admin_name = :admin_name, 
		sallesport_name = :sallesport_name, 
		sallesport_address = :sallesport_address, 
		sallesport_contact_no = :sallesport_contact_no, 
		sallesport_logo = :sallesport_logo 
		WHERE admin_id = '".$_SESSION["admin_id"]."'
		";
		$object->execute($data);

		$success = '<div class="alert alert-success">Admin Data Updated</div>';

		$output = array(
			'error'					=>	$error,
			'success'				=>	$success,
			'admin_email_address'	=>	$_POST["admin_email_address"],
			'admin_password'		=>	$_POST["admin_password"],
			'admin_name'			=>	$_POST["admin_name"], 
			'sallesport_name'			=>	$_POST["sallesport_name"],
			'sallesport_address'		=>	$_POST["sallesport_address"],
			'sallesport_contact_no'	=>	$_POST["sallesport_contact_no"],
			'sallesport_logo'			=>	$sallesport_logo
		);

		echo json_encode($output);
	}
	else
	{
		$output = array(
			'error'					=>	$error,
			'success'				=>	$success
		);
		echo json_encode($output);
	}
}

?>