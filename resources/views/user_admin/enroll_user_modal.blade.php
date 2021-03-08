<style type="text/css">
  select{
        border-radius: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-left: 0px !important;
        border-bottom: solid 3px #3490dc !important
        box-shadow: none !important;
        background-color: transparent;
  }

  /*fixed header*/
  tbody {
      display:block;
      height:700px;
      overflow:auto;
  }
  thead, tbody tr {
      display:table;
      width:100%;
      table-layout:fixed;
      font-size: .9em;
  }
  thead {
      width: calc( 100% - 1em )
  }
  /*fixed header*/

  tr:hover{
    cursor: pointer;
    border-left: 5px solid #007bff;
    background-color: rgba(0, 123, 255, .10);
    font-weight: bold;
  }

  .table td{
    border: 0px;
  }

  input[type="text"], 
  input[type="password"],
  input[type="email"]{
    border-radius: 0px !important;
    border-top: none;
    border-right: none;
    border-left: none;
    border-bottom: solid 2px #007bff;
    box-shadow: none !important;
    background-color: transparent;
  }
</style>

<div class="modal fade" id="enroll_new_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md rounded-0" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="font-weight-light">Enroll User <i class="fa fa-user-plus"></i></h5>
		</div>
		<div class="modal-body">
			<form name="myForm1">
				<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Modality </small></label>
						<select class="custom-select" ng-model="user_modality" name="user_modality" required>
						<option value="1" selected>KKB</option>
						<option value="2">MAKILAHOK</option>
						<option value="3">NCDDP</option>
						<option value="4">IP CDD</option>
						<option value="5">CCL</option>
						<option value="6">L&E</option>
						</select>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="form-group">
						<label class="mt-2 mb-0"><small class="font-weight-bold">Firstname</small></label>
						<input type="text" class="form-control" ng-model="fname" placeholder="ex. John Paul" name="fname" required>
					</div>

					<div class="form-group">
						<label class="mt-2 mb-0"><small class="font-weight-bold">Middlename</small></label>
						<input type="text" class="form-control" ng-model="mname" placeholder="ex. Amper" name="mname" required>
					</div>

					<div class="form-group">
						<label class="mt-2 mb-0"><small class="font-weight-bold">Lastname</small></label>
						<input type="text" class="form-control" ng-model="lname" placeholder="ex. Quiñal" name="lname" required>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Employee ID </small></label>
						<input type="text" class="form-control" ng-model="emp_id_no" name="emp_id_no" required>
					</div>

					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Birthdate </small></label>
						<input type="date" class="form-control" ng-model="bdate" name="bdate" required>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary">Email</small></label>
						<input type="email" class="form-control" ng-model="email" name="email" placeholder="ex. radicaljhonpaul@gmail.com" required>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary">Phone</small></label>
						<input type="text" class="form-control" ng-model="contact" name="contact" placeholder="09568625633" required>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Username </small></label>
						<input type="text" class="form-control" ng-model="username" name="username" required>
					</div>

					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Password </small></label>
						<input type="password" class="form-control" ng-model="password" name="password" required>
					</div>

					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Role </small></label>
						<select class="custom-select" ng-model="user_role" name="user_role" required>
							<option value="DAC" selected>DAC</option>
							<option value="RPMO">RPMO</option>
							<option value="MAINSTREAM">MAINSTREAM</option>
							<option value="PROCUREMENT">PROCUREMENT</option>
						</select>
					</div>
				</div>

				</div>
			</form>
		</div>
			<div class="modal-footer">
				<span ng-IF="myForm1.$valid == false"> <small>Please fill all the fields...</small> </span>
				<button ng-disabled="myForm1.$valid == false" type="button" class="btn btn-success" style="border-radius: 100px;" ng-click="enroll_user(myForm1)"> <i class="fa fa-certificate"></i> Enroll User</button>
				<button type="button" class="btn btn-secondary" style="border-radius: 100px;" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>