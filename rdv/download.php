<?php

//download.php

include('class/Appointment.php');

$object = new Appointment;

require_once('class/pdf.php');

if(isset($_GET["id"]))
{
	$html = '<table border="0" cellpadding="5" cellspacing="5" width="100%">';

	$object->query = "
	SELECT sallesport_name, sallesport_address, sallesport_contact_no, sallesport_logo 
	FROM admin_table
	";

	$sallesport_data = $object->get_result();

	foreach($sallesport_data as $sallesport_row)
	{
		$html .= '<tr><td align="center">';
		if($sallesport_row['sallesport_logo'] != '')
		{
			$html .= '<img src="'.substr($sallesport_row['sallesport_logo'], 3).'" /><br />';
		}
		$html .= '<h2 align="center">'.$sallesport_row['sallesport_name'].'</h2>
		<p align="center">'.$sallesport_row['sallesport_address'].'</p>
		<p align="center"><b>Numero de telephone - </b>'.$sallesport_row['sallesport_contact_no'].'</p></td></tr>
		';
	}

	$html .= "
	<tr><td><hr /></td></tr>
	<tr><td>
	";

	$object->query = "
	SELECT * FROM appointment_table 
	WHERE appointment_id = '".$_GET["id"]."'
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
		
		$html .= '
		<h4 align="center">Details du Client</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">';

		foreach($client_data as $client_row)
		{
			$html .= '<tr><th width="50%" align="right">Nom du Client</th><td>'.$client_row["client_first_name"].' '.$client_row["client_last_name"].'</td></tr>
			<tr><th width="50%" align="right">Numero de telephone</th><td>'.$client_row["client_phone_no"].'</td></tr>
			<tr><th width="50%" align="right">Addresse</th><td>'.$client_row["client_address"].'</td></tr>';
		}

		$html .= '</table><br /><hr />
		<h4 align="center">Details RDV</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">
			<tr>
				<th width="50%" align="right">Num de RDV</th>
				<td>'.$appointment_row["appointment_number"].'</td>
			</tr>
		';
		foreach($coach_schedule_data as $coach_schedule_row)
		{
			$html .= '
			<tr>
				<th width="50%" align="right">Nom du Coach</th>
				<td>'.$coach_schedule_row["coach_name"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Date de RDV</th>
				<td>'.$coach_schedule_row["coach_schedule_date"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Jour de RDV</th>
				<td>'.$coach_schedule_row["coach_schedule_day"].'</td>
			</tr>
				
			';
		}

		$html .= '
			<tr>
				<th width="50%" align="right">Heure de RDV</th>
				<td>'.$appointment_row["appointment_time"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Raison du RDV</th>
				<td>'.$appointment_row["reason_for_appointment"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Client vient a la salle de sport</th>
				<td>'.$appointment_row["client_come_into_sallesport"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Commentaire du Coach</th>
				<td>'.$appointment_row["coach_comment"].'</td>
			</tr>
		</table>
			';
	}

	$html .= '
			</td>
		</tr>
	</table>';

	echo $html;

	$pdf = new Pdf();

	$pdf->loadHtml($html, 'UTF-8');
	$pdf->render();
	ob_end_clean();
	//$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>1 ));
	$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>false ));
	exit(0);

}

?>