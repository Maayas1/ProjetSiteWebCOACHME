<?php

//coach.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Gestion des Coachs</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-primary">Liste des Coachs</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_coach" id="add_coach" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="coach_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Email </th>
                                            <th>Password</th>
                                            <th>Nom du Coach</th>
                                            <th>Numero de telephone du Coach</th>
                                            <th>Specialitee du Coach</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>

<div id="coachModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="coach_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Ajouter coach</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>coach Email <span class="text-danger">*</span></label>
                                <input type="text" name="coach_email_address" id="coach_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Mot de passe du Coach <span class="text-danger">*</span></label>
                                <input type="password" name="coach_password" id="coach_password" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nom du Coach <span class="text-danger">*</span></label>
                                <input type="text" name="coach_name" id="coach_name" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Num de telephone du Coach <span class="text-danger">*</span></label>
                                <input type="text" name="coach_phone_no" id="coach_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Coach Addresse </label>
                                <input type="text" name="coach_address" id="coach_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Date de Naissance du Coach </label>
                                <input type="text" name="coach_date_of_birth" id="coach_date_of_birth" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Diplomes du Coach <span class="text-danger">*</span></label>
                                <input type="text" name="coach_degree" id="coach_degree" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Specialité du Coach <span class="text-danger">*</span></label>
                                <input type="text" name="coach_expert_in" id="coach_expert_in" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Image du coach <span class="text-danger">*</span></label>
                        <br />
                        <input type="file" name="coach_profile_image" id="coach_profile_image" />
                        <div id="uploaded_image"></div>
                        <input type="hidden" name="hidden_coach_profile_image" id="hidden_coach_profile_image" />
                    </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Voir details du Coach</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="coach_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#coach_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"coach_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2, 4, 5, 6, 7],
				"orderable":false,
			},
		],
	});

    $('#coach_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#add_coach').click(function(){
		
		$('#coach_form')[0].reset();

		$('#coach_form').parsley().reset();

    	$('#modal_title').text('Add coach');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#coachModal').modal('show');

    	$('#form_message').html('');

	});

	$('#coach_form').parsley();

	$('#coach_form').on('submit', function(event){
		event.preventDefault();
		if($('#coach_form').parsley().isValid())
		{		
			$.ajax({
				url:"coach_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:'json',
                contentType: false,
                cache: false,
                processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Add');
					}
					else
					{
						$('#coachModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var coach_id = $(this).data('id');

		$('#coach_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"coach_action.php",

	      	method:"POST",

	      	data:{coach_id:coach_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#coach_email_address').val(data.coach_email_address);

                $('#coach_email_address').val(data.coach_email_address);
                $('#coach_password').val(data.coach_password);
                $('#coach_name').val(data.coach_name);
                $('#uploaded_image').html('<img src="'+data.coach_profile_image+'" class="img-fluid img-thumbnail" width="150" />')
                $('#hidden_coach_profile_image').val(data.coach_profile_image);
                $('#coach_phone_no').val(data.coach_phone_no);
                $('#coach_address').val(data.coach_address);
                $('#coach_date_of_birth').val(data.coach_date_of_birth);
                $('#coach_degree').val(data.coach_degree);
                $('#coach_expert_in').val(data.coach_expert_in);

	        	$('#modal_title').text('Modifier Coach');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#coachModal').modal('show');

	        	$('#hidden_id').val(coach_id);

	      	}

	    })

	});

	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var next_status = 'Active';
		if(status == 'Active')
		{
			next_status = 'Inactive';
		}
		if(confirm("Are you sure you want to "+next_status+" it?"))
    	{

      		$.ajax({

        		url:"coach_action.php",

        		method:"POST",

        		data:{id:id, action:'change_status', status:status, next_status:next_status},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}
	});

    $(document).on('click', '.view_button', function(){
        var coach_id = $(this).data('id');

        $.ajax({

            url:"coach_action.php",

            method:"POST",

            data:{coach_id:coach_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><td colspan="2" class="text-center"><img src="'+data.coach_profile_image+'" class="img-fluid img-thumbnail" width="150" /></td></tr>';

                html += '<tr><th width="40%" class="text-right">coach Email Address</th><td width="60%">'+data.coach_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Mot de passe du Coach </th><td width="60%">'+data.coach_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Nom du Coach </th><td width="60%">'+data.coach_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Num de Tel du Coach</th><td width="60%">'+data.coach_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Addresse du Coach </th><td width="60%">'+data.coach_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Date de naissance du Coach</th><td width="60%">'+data.coach_date_of_birth+'</td></tr>';
                html += '<tr><th width="40%" class="text-right">coach Qualifications</th><td width="60%">'+data.coach_degree+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">coach Specialitee</th><td width="60%">'+data.coach_expert_in+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#coach_details').html(html);

            }

        })
    });

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"coach_action.php",

        		method:"POST",

        		data:{id:id, action:'delete'},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}

  	});



});
</script>