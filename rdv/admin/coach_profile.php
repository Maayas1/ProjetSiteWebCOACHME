<?php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."");
}

if($_SESSION['type'] != 'Coach')
{
    header("location:".$object->base_url."");
}

$object->query = "
    SELECT * FROM coach_table
    WHERE coach_id = '".$_SESSION["admin_id"]."'
    ";

$result = $object->get_result();

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Profil</h1>

                    <!-- DataTales Example -->
                    
                    <form method="post" id="profile_form" enctype="multipart/form-data">
                        <div class="row"><div class="col-md-10"><span id="message"></span><div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                                    </div>
                                    <div clas="col" align="right">
                                        <input type="hidden" name="action" value="coach_profile" />
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <button type="submit" name="edit_button" id="edit_button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Modifier</button>
                                        &nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--<div class="row">
                                    <div class="col-md-6">!-->
                                        <span id="form_message"></span>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>coach Email Address <span class="text-danger">*</span></label>
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
                                                    <label>Num de tel du Coach <span class="text-danger">*</span></label>
                                                    <input type="text" name="coach_phone_no" id="coach_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Addresse du Coach </label>
                                                    <input type="text" name="coach_address" id="coach_address" class="form-control" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Date de naissance du Coach </label>
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
                                                    <label>Specialitees du Coach <span class="text-danger">*</span></label>
                                                    <input type="text" name="coach_expert_in" id="coach_expert_in" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Image du Coach <span class="text-danger">*</span></label>
                                            <br />
                                            <input type="file" name="coach_profile_image" id="coach_profile_image" />
                                            <div id="uploaded_image"></div>
                                            <input type="hidden" name="hidden_coach_profile_image" id="hidden_coach_profile_image" />
                                        </div>
                                    <!--</div>
                                </div>!-->
                            </div>
                        </div></div></div>
                    </form>
                <?php
                include('footer.php');
                ?>

<script>
$(document).ready(function(){

    $('#coach_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

    <?php
    foreach($result as $row)
    {
    ?>
    $('#hidden_id').val("<?php echo $row['coach_id']; ?>");
    $('#coach_email_address').val("<?php echo $row['coach_email_address']; ?>");
    $('#coach_password').val("<?php echo $row['coach_password']; ?>");
    $('#coach_name').val("<?php echo $row['coach_name']; ?>");
    $('#coach_phone_no').val("<?php echo $row['coach_phone_no']; ?>");
    $('#coach_address').val("<?php echo $row['coach_address']; ?>");
    $('#coach_date_of_birth').val("<?php echo $row['coach_date_of_birth']; ?>");
    $('#coach_degree').val("<?php echo $row['coach_degree']; ?>");
    $('#coach_expert_in').val("<?php echo $row['coach_expert_in']; ?>");
    
    $('#uploaded_image').html('<img src="<?php echo $row["coach_profile_image"]; ?>" class="img-thumbnail" width="100" /><input type="hidden" name="hidden_coach_profile_image" value="<?php echo $row["coach_profile_image"]; ?>" />');

    $('#hidden_coach_profile_image').val("<?php echo $row['coach_profile_image']; ?>");
    <?php
    }
    ?>

    $('#coach_profile_image').change(function(){
        var extension = $('#coach_profile_image').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['png','jpg']) == -1)
            {
                alert("Invalid Image File");
                $('#coach_profile_image').val('');
                return false;
            }
        }
    });

    $('#profile_form').parsley();

	$('#profile_form').on('submit', function(event){
		event.preventDefault();
		if($('#profile_form').parsley().isValid())
		{		
			$.ajax({
				url:"profile_action.php",
				method:"POST",
				data:new FormData(this),
                dataType:'json',
                contentType:false,
                processData:false,
				beforeSend:function()
				{
					$('#edit_button').attr('disabled', 'disabled');
					$('#edit_button').html('wait...');
				},
				success:function(data)
				{
					$('#edit_button').attr('disabled', false);
                    $('#edit_button').html('<i class="fas fa-edit"></i> Edit');

                    $('#coach_email_address').val(data.coach_email_address);
                    $('#coach_password').val(data.coach_password);
                    $('#coach_name').val(data.coach_name);
                    $('#coach_phone_no').val(data.coach_phone_no);
                    $('#coach_address').text(data.coach_address);
                    $('#coach_date_of_birth').text(data.coach_date_of_birth);
                    $('#coach_degree').text(data.coach_degree);
                    $('#coach_expert_in').text(data.coach_expert_in);
                    if(data.coach_profile_image != '')
                    {
                        $('#uploaded_image').html('<img src="'+data.coach_profile_image+'" class="img-thumbnail" width="100" />');

                        $('#user_profile_image').attr('src', data.coach_profile_image);
                    }

                    $('#hidden_coach_profile_image').val(data.coach_profile_image);
						
                    $('#message').html(data.success);

					setTimeout(function(){

				        $('#message').html('');

				    }, 5000);
				}
			})
		}
	});

});
</script>