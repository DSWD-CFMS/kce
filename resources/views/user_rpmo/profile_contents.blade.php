<style type="text/css">
    /*uploads css*/
    input[type=file] {
      cursor: pointer;
      width: 100%;
      height: 42px;
      overflow: hidden;
      color:transparent;
    }

    input[type=file]:before {
      width: 100%;
      height: 42px;
      font-size: 16px;
      color:#007bff;
      line-height: 32px;
      content: 'Select files to be uploaded';
      display: inline-block;
      background: white;
      border: 2px solid #007bff;
      border-radius: 26px;
      text-align: center;
      font-family: Helvetica, Arial, sans-serif;
    }

    input[type=file]::-webkit-file-upload-button {
      visibility: hidden !important;
    }
</style>
<!-- FILES -->
<div class="row wrapper page-heading animated fadeInRight mt-5" ng-init="show_profile();fetch_my_modalities();">
    <div class="col-lg-4">
      <div class="widget-head-color-box rounded-0 p-lg pt-3">
          <h2 class="font-weight-light my-0">Display photo</h2>
          <hr>
          @verbatim
          <img ng-if="PhotoObj.length > 0" alt="image" class="img-fluid" src="/get_profile_photo/{{Profile[0].id}}" style="height: 200px; width: 100%;padding: 5px; object-fit: contain;">
          @endverbatim

          <img ng-if="PhotoObj.length == 0" alt="image" class="img-fluid" src="https://image.flaticon.com/icons/svg/747/747376.svg" style="height: 200px; width: 100%;padding: 5px; object-fit: contain;">
          
          <button class="btn btn-outline-primary btn-block rounded-0 mt-2" ng-hide="try_upload_file_btn == true" ng-click="try_upload_file()" > <i class="fa fa-camera-retro"></i> Change Display Photo</button>

          <div class="form-group mt-2" ng-hide="try_upload_file_btn == false">
            <div class="text-center">
              <input id="customFile" type="file" ng-model="Upload_files" onchange="angular.element(this).scope().fileChanged_profile(this)">
              <hr>
              <p class="font-weight-bold" id="preview"></p>
            </div>
          </div>
          <button class="btn btn-outline-primary btn-block rounded-0" ng-hide="try_upload_file_btn == false" ng-disabled=" file_upload.length == 0 || file_upload.length == null" ng-click="upload_profile_picture()" > <i class="fa fa-camera-retro"></i> Save Changes </button>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="widget-head-color-box rounded-0 p-lg pt-3">
        <div class="row">
          <div class="col text-left">
            <h2 class="font-weight-light my-0">Personal Information</h2>
          </div>
          <div class="col text-right">
            <button ng-if="try_update_profileinfo_btn == false" ng-click="try_update_profileinfo()" type="button" class="btn btn-outline-primary rounded-0"><i class="fa fa-pencil-square-o"></i> Update Profile Info</button>
          </div>
        </div>

          <hr>
          <div id="info" ng-if="try_update_profileinfo_btn == false" ng-cloak>
            <h1><strong ng-bind="Profile[0].Fname +' '+ Profile[0].Lname"></strong></h1>
            <h4 class="mb-0"><i class="fa fa-envelope-o"></i> <span ng-bind="Profile[0].email"></span></h4>
            <h4 class="mt-0"><i class="fa fa-barcode"></i> <span ng-bind="Profile[0].emp_id_no"></span></h4>
            
            <h3 class="mt-2">PERKS</h3>
            <p class="mt-0">
                This account can overseen assigned subprojects. Also this account can received sms updates of Subprojects upon submission.
            </p>

            <h3 class="mt-3"><i class="fa fa-phone"></i> <span ng-bind="Profile[0].contact"></span></h3>
            <hr>
            <div class="row pb-3 mt-3">
              <div class="col-md-4">
                  <!-- <span class="bar">5,3,9,6,5,9,7,3,5,2</span> -->
                  <h5 class="mb-0"><strong ng-bind="Profile[0].files.length">169</strong></h5>
                  <span> Files </span>
              </div>
              <div class="col-md-4">
                  <!-- <span class="line">5,3,9,6,5,9,7,3,5,2</span> -->
                  <h5 class="mb-0"><strong ng-bind="Profile[0].assigned_sp.length"></strong></h5>
                  <span>Subprojects</span>
              </div>
              <div class="col-md-4">
                  <!-- <span class="bar">5,3,2,-1,-3,-2,2,3,5,2</span> -->
                  <span style="font-size: .8em;" class="mb-0" ng-repeat="data in Profile[0].assigned_grouping">
                  	<strong ng-bind="data.sp_groupings[0].grouping + ','"></strong>
                  </span>
                  <br>
                  <span>Modality</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12" id="info_edit" ng-if="try_update_profileinfo_btn == true" ng-cloak>
              <div class="form-group">
                <label>Firstname</label>
                <input class="form-control" type="text" name="fname" ng-model="Profile[0].Fname">

                <label>Middlename</label>
                <input class="form-control" type="text" name="mname" ng-model="Profile[0].Mname">

                <label>Lastname</label>
                <input class="form-control" type="text" name="lname" ng-model="Profile[0].Lname">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="text" name="email" ng-model="Profile[0].email">
              </div>
              <div class="form-group">
                <label>Employee ID No.</label>
                <input class="form-control" type="text" name="emp_id_no" ng-model="Profile[0].emp_id_no">
              </div>

              <div class="form-group">
                <label>Contact</label>
                <input class="form-control" type="text" name="phone" ng-model="Profile[0].contact">
              </div>
            </div>

            <div class="col-lg-12">
              <button ng-if="try_update_profileinfo_btn == true" ng-click="update_profileinfo(
                Profile[0].Fname,Profile[0].Mname,Profile[0].Lname,Profile[0].email,Profile[0].emp_id_no,Profile[0].contact)" type="button" class="btn btn-outline-success btn-block rounded-0"><i class="fa fa-pencil-square-o"></i> Save Profile Info</button>

              <button ng-if="try_update_profileinfo_btn == true" ng-click="cancel_update_profileinfo()" type="button" class="btn btn-outline-secondary btn-block rounded-0"><i class="fa fa-times"></i> Cancel Update </button>
            </div>
          </div>
      </div>
    </div>

</div>
