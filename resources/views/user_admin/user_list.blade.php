<!-- MODALITY -->
<div class="border-bottom dashboard-header animated fadeInRight" ng-init="fetch_users(3,2020);show_profile()">
    <div class="row wrapper animated fadeInRight ecommerce px-0 pb-0 ">

      <div class="col-lg-10">
        <h2> Users </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ url('/admin_rcis/routes') }}" >Home</a>
            </li>
            <li class="breadcrumb-item">
                <strong> Users </strong>
            </li>
        </ol>
      </div>

      <div class="col-lg-2">
        <button class="btn btn-outline-success rounded-0" data-backdrop="static" data-keyboard="false" data-target="#enroll_new_user" data-toggle="modal"> Enroll User <i class="fa fa-user-plus"></i> </button>
      </div>

      <div class="col-lg-4 my-2">
      	<span ng-bind="sp_per_modality.current_page"></span>
      	<span ng-bind="sp_per_modality.last_page"></span>
        <label><small> Search Users <i class="fa fa-search"></i> </small></label>
        <input class="form-control nav-item nav-link" type="text" name="" placeholder="Search..." ng-model="search_data_nys.$">
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
        <th scope="col">Enrolled On</th>
        <th scope="col">Name</th>
        <th scope="col">Modality</th>
        <th scope="col">ID</th>
        <th scope="col">Role</th>
        <th scope="col">Contact</th>
        <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody >
        <tr ng-repeat="users in bars = (user_list | filter: search_data_nys.$) track by $index"id="user_list" id="user_list" style="cursor: pointer;" ng-click="fetch_specific_pmr_data(data)" data-dismiss="modal">
          <td ng-bind="users.created_at | date:'medium'"></td>
          <td ng-bind="(users.Fname) +' '+ (users.Lname)"></td>
          <td>
            <p ng-if="users.role == 'DAC'" class="mt-2 mb-2" ng-bind="users.sp_groupings[0].grouping"></p>
            <span class="mt-2 mb-2">
              <span ng-repeat="data in users.assigned_grouping">
                <span ng-bind="data.sp_groupings[0].grouping +', '"></span>
              </span>
            </span>
          </td>
          <td ng-bind="users.emp_id_no"></td>
          <td ng-bind="users.role"></td>
          <td ng-bind="users.contact"></td>
          <td>
            <div class="input-group">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary rounded-0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_modality" ng-click="specific_user(users)"><i class="fa fa-plus-circle"></i></button>
              </div>
              <button class="btn btn-outline-danger rounded-0" data-backdrop="static" ng-click="delete_user(users.id)"> <i class="fa fa-trash"></i> </button>            
            </div>


          </td>
        </tr>
      </tbody>
    </table>
</div>
<!-- MODALITY -->

@include('user_admin.add_sp_modal')
@include('user_admin.enroll_user_modal')
