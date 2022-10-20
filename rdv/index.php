<?php

//index.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_SESSION['client_id']))
{
	header('location:dashboard.php');
}

$object->query = "
SELECT * FROM coach_schedule_table 
INNER JOIN coach_table 
ON coach_table.coach_id = coach_schedule_table.coach_id
WHERE coach_schedule_table.coach_schedule_date >= '".date('Y-m-d')."' 
AND coach_schedule_table.coach_schedule_status = 'Active' 
AND coach_table.coach_status = 'Active' 
ORDER BY coach_schedule_table.coach_schedule_date ASC
";

$result = $object->get_result();

include('header.php');

?>
		      	<div class="card">
		      		<form method="post" action="result.php">
			      		<div class="card-header"><h3><b>Planning Coach</b></h3></div>
			      		<div class="card-body">
		      				<div class="table-responsive">
		      					<table class="table table-striped table-bordered">
		      						<tr>
		      							<th>Nom du Coach</th>
		      							<th>Diplomes</th>
		      							<th>Specialitee</th>
		      							<th>Date de RDV</th>
		      							<th>Jour de RDV</th>
		      							<th>Temps</th>
		      							<th>Action</th>
		      						</tr>
		      						<?php
		      						foreach($result as $row)
		      						{
		      							echo '
		      							<tr>
		      								<td>'.$row["coach_name"].'</td>
		      								<td>'.$row["coach_degree"].'</td>
		      								<td>'.$row["coach_expert_in"].'</td>
		      								<td>'.$row["coach_schedule_date"].'</td>
		      								<td>'.$row["coach_schedule_day"].'</td>
		      								<td>'.$row["coach_schedule_start_time"].' - '.$row["coach_schedule_end_time"].'</td>
		      								<td><button type="button" name="get_appointment" class="btn btn-primary btn-sm get_appointment" data-id="'.$row["coach_schedule_id"].'">Reserver RDV</button></td>
		      							</tr>
		      							';
		      						}
		      						?>
		      					</table>
		      				</div>
		      			</div>
		      		</form>
		      	</div>
		    

<?php

include('footer.php');

?>

<script>

$(document).ready(function(){
	$(document).on('click', '.get_appointment', function(){
		var action = 'check_login';
		var coach_schedule_id = $(this).data('id');
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:action, coach_schedule_id:coach_schedule_id},
			success:function(data)
			{
				window.location.href=data;
			}
		})
	});
});

</script>