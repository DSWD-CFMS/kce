<!-- UPLOAD -->
<div class="row justify-content-center">
  <div class="col-lg-12 mb-3">
    <h2 class="font-weight-bold">Uploads</h2>
    <p class="font-weight-light"> Upload your works and or files for reviewing </p>
  </div>

  <div class="col-lg-3">

    <div class="py-5 shadow1" style="border-radius: 0.25rem;">

      <div class="form-group mb-5">
        <label for="inputState">Category</label>
        <small id="emailHelp" class="form-text text-muted">These tags helps in grouping your uploaded files</small>
        <select id="inputState" class="form-control" ng-model="uploaded_category">
          <option selected></option>
          <option value="SP_files"> SP files </option>
          <option value="Standard Drawing Plans"> Standard Drawing Plans </option>
          <option value="O&M Feedback Report"> O&M Feedback Report </option>
          <option value="Procurement Documents"> Procurement Documents </option>
          <option value="O&M Blgu certificate"> O&M Blgu certificate </option>
          <option value="O&M Billboard"> O&M Billboard </option>

          <option value="O&M"> O&M </option>
          <option value="Geo-Tagged Photos"> Geo-Tagged Photos </option>
          <option value="Publication"> Publication </option>
          <option value="Monitoring"> Monitoring </option>
          <option value="SI Report"> SI Report </option>

          <option value="Photo Documents"> Photo Documents </option>
          <option value="Field Report"> Field Report </option>
          <option value="Site Validation"> Site Validation </option>
          <option value="Presentation"> Presentation </option>
          <option value="Resolution"> Resolution </option>

          <option value="Spotcheck"> Spotcheck </option>
          <option value="Manuals"> Manuals </option>
          <option value="Letters"> Letters </option>
          <option value="Reports"> Reports </option>
          <option value="Minutes"> Minutes </option>

          <option value="LARR"> LARR </option>
          <option value="Policy"> Policy </option>
          <option value="Video"> Video </option>
          <option value="Memos"> Memos </option>
          <option value="Forms"> Forms </option>

          <option value="NOL"> NOL </option>
          <option value="Monthly Plan"> Monthly Plan </option>
          <option value="Accomplishments"> Accomplishments </option>
          <option value="Others"> Others </option>
        </select>
      </div>
  
      <div class="form-group mb-5">
        <div class="text-center">
          <input id="customFile" type="file" multiple ng-model="Upload_files" onchange="angular.element(this).scope().fileChanged(this)">
          <hr>
          <ul class="list-group mt-3" id="preview" style="max-height: 300px; overflow-y: auto;">
          </ul>
        </div>
      </div>

      <div class="form-group">
        <button class="btn btn-primary btn-block" style="border-radius: 0px;" ng-disabled="uploaded_category == null || uploaded_category == '' || file_upload.length == 0 || file_upload.length == null" ng-click="upload_file(uploaded_category)"> <i class="fa fa-upload"></i> Upload</button>
      </div>
    </div>

  </div>

  <div class="col-lg-9" style="border-left: solid 2px #eeeeee66; height: 100%;">
    <div class="row">
      <div class="col-lg-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#recent" role="tab" data-toggle="tab">Recently uploaded</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#files" role="tab" data-toggle="tab">My Files</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#all_files" role="tab" data-toggle="tab">All Files</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <br>
          <div role="tabpanel" class="tab-pane active" id="recent" ng-init="fetch_my_latest_file()">
            <h4 class="pb-3">Recently uploaded files</h4>
            <div class="row">
              @verbatim
              <div class="col-lg-4" ng-repeat="files in file_data">
                <p class="py-2 pl-2" style="border-left:solid 2px #007bff;">
                  <b>Filename:</b> <span ng-bind="files.filename"></span> <br>
                  <b>Category:</b> <span ng-bind="files.category"></span> <br>
                  <small> <b>Uploaded On:</b> <span ng-bind="files.updated_at | date:'mediumDate'"></span> </small> <br>
                  <button class="btn btn-secondary btn-sm mt-1" style="border-radius: 16px;"> <i class="fa fa-download"></i> <a class="text-light" href="/rpmo/routes/download/{{files.id}}"> Download </a> </button>
                </p>
              </div>
              @endverbatim
            </div>
          </div>

          <div role="tabpanel" class="tab-pane" id="files" ng-init="fetch_my_all_file()">
            <div class="row">
              <div class="col-lg-6 mb-3"><h4 class="pb-3">My Files</h4></div>
              <!-- Category -->
              <div class="col-lg-3 mb-3 px-2">
                <label for="inputState">Category</label>
                <select id="inputState" class="form-control" ng-model="search_data.category">
                  <option value="" selected="true">All</option>
                  <option value="SP_files"> SP files </option>
                  <option value="Standard Drawing Plans"> Standard Drawing Plans </option>
                  <option value="O&M Feedback Report"> O&M Feedback Report </option>
                  <option value="Procurement Documents"> Procurement Documents </option>
                  <option value="O&M Blgu certificate"> O&M Blgu certificate </option>
                  <option value="O&M Billboard"> O&M Billboard </option>

                  <option value="O&M"> O&M </option>
                  <option value="Geo-Tagged Photos"> Geo-Tagged Photos </option>
                  <option value="Publication"> Publication </option>
                  <option value="Monitoring"> Monitoring </option>
                  <option value="SI Report"> SI Report </option>

                  <option value="Photo Documents"> Photo Documents </option>
                  <option value="Field Report"> Field Report </option>
                  <option value="Site Validation"> Site Validation </option>
                  <option value="Presentation"> Presentation </option>
                  <option value="Resolution"> Resolution </option>

                  <option value="Spotcheck"> Spotcheck </option>
                  <option value="Manuals"> Manuals </option>
                  <option value="Letters"> Letters </option>
                  <option value="Reports"> Reports </option>
                  <option value="Minutes"> Minutes </option>

                  <option value="LARR"> LARR </option>
                  <option value="Policy"> Policy </option>
                  <option value="Video"> Video </option>
                  <option value="Memos"> Memos </option>
                  <option value="Forms"> Forms </option>

                  <option value="NOL"> NOL </option>
                  <option value="Monthly Plan"> Monthly Plan </option>
                  <option value="Accomplishments"> Accomplishments </option>
                  <option value="Others"> Others </option>
                </select>
              </div>

              <!-- Searching -->
              <div class="col-lg-3 mb-3 px-2">
                <div class="form-group">
                  <label>Search</label>
                  <input class="form-control" type="text" name="search_files" ng-model="search_data.name" placeholder="ex. Filename.pdf" ng-disabled="search_data.category == undefined">
                </div>
              </div>
            </div>

            <!-- Ipakita sa tanan files from recent to outdated -->
            <div class="col-lg-12" style="height: 550px; overflow-y: scroll;">
              <div class="row">
                <div class="col-lg-3" ng-repeat="all_files in my_all_file_data | filter: search_data.name | filter: search_data.category">
                  @verbatim
                  <p class="py-2 pl-2" style="border-left:solid 2px #007bff;">
                    <b>Filename:</b> <span ng-bind="all_files.filename"></span> <br>
                    <b>Category:</b> <span ng-bind="all_files.category"></span> <br>
                    <small> <b>Uploaded On:</b> <span ng-bind="all_files.updated_at | date:'fullDate'"></span> </small> <br>
                    <button class="btn btn-secondary btn-sm mt-1" style="border-radius: 16px;"> <i class="fa fa-download"></i> <a class="text-light" href="/rpmo/routes/download/{{all_files.id}}"> Download </a> </button>
                  </p>
                  @endverbatim
                </div>
              </div>
            </div>
          </div>

          <!-- ALL FILES APIL SA DILI IYAHA -->
          <div role="tabpanel" class="tab-pane" id="all_files" ng-init="fetch_all_file();fetch_users_list();">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 mb-3">
          <h4 class="">All Files</h4>
        </div>

        <div class="col-lg-2 mb-3 px-2 text-right">
          <div class="form-group">
            <label>Clear Filter </label><br>
            <button class="btn btn-danger" style="border-radius: 26px !important;" ng-click="clearFilter()"> &nbsp;&nbsp; <i class="fa fa-eraser"></i> &nbsp;&nbsp;</button>
          </div>
        </div>

        <div class="col-lg-2 mb-3 px-2">
          <label for="inputState">Origin</label>
           <select class="form-control" ng-options="emp.Fname as (emp.Fname +' '+ emp.Lname) for emp in users_list" ng-model="search_data.origin"></select>
        </div>

        <!-- Category -->
        <div class="col-lg-2 mb-3 px-2">
          <label for="inputState">Category</label>
          <select id="inputState" class="form-control" ng-model="search_data.category" ng-disabled="search_data.origin == undefined">
            <option value="" selected>All</option>

            <option value="SP_files"> SP files </option>
            <option value="Standard Drawing Plans"> Standard Drawing Plans </option>
            <option value="O&M Feedback Report"> O&M Feedback Report </option>
            <option value="Procurement Documents"> Procurement Documents </option>
            <option value="O&M Blgu certificate"> O&M Blgu certificate </option>
            <option value="O&M Billboard"> O&M Billboard </option>

            <option value="O&M"> O&M </option>
            <option value="Geo-Tagged Photos"> Geo-Tagged Photos </option>
            <option value="Publication"> Publication </option>
            <option value="Monitoring"> Monitoring </option>
            <option value="SI Report"> SI Report </option>

            <option value="Photo Documents"> Photo Documents </option>
            <option value="Field Report"> Field Report </option>
            <option value="Site Validation"> Site Validation </option>
            <option value="Presentation"> Presentation </option>
            <option value="Resolution"> Resolution </option>

            <option value="Spotcheck"> Spotcheck </option>
            <option value="Manuals"> Manuals </option>
            <option value="Letters"> Letters </option>
            <option value="Reports"> Reports </option>
            <option value="Minutes"> Minutes </option>

            <option value="LARR"> LARR </option>
            <option value="Policy"> Policy </option>
            <option value="Video"> Video </option>
            <option value="Memos"> Memos </option>
            <option value="Forms"> Forms </option>

            <option value="NOL"> NOL </option>
            <option value="Monthly Plan"> Monthly Plan </option>
            <option value="Accomplishments"> Accomplishments </option>
            <option value="Others"> Others </option>
          </select>
        </div>

        <!-- Searching -->
        <div class="col-lg-2 mb-3 px-2">
          <div class="form-group">
            <label>Search</label>
            <input class="form-control" type="text" name="search_files" placeholder="ex. Filename.pdf" ng-model="search_data.name" ng-disabled="search_data.category == undefined">
          </div>
        </div>

      </div>

      <div class="row">
        @verbatim
        <div class="col-lg-3"  ng-repeat="all_files in bars = (all_file_data | filter: search_data.name | filter: search_data.category | filter: search_data.origin)" ng-cloak>
          <p class="py-2 mb-0 pl-2 text-truncate" style="border-left:solid 2px #007bff; max-width: 290px;">
            <b>Filename:</b> <span ng-bind="all_files.filename"></span>
          </p>
          <p class="py-2 pl-2" style="border-left:solid 2px #007bff;">
            <b>Category:</b> <span ng-bind="all_files.category"></span> <br>
            <b>Origin:</b> <span ng-bind="(all_files.users.Fname +' '+ all_files.users.Lname)"></span> <br>
            <small> <b>Uploaded On:</b> <span ng-bind="all_files.updated_at | date:'fullDate'"></span> </small> <br>
            <button class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{all_files.id}}"> Download </a> </button>
          </p>

          </p>
        </div>
        @endverbatim
        <div class="col-lg-12 text-center" ng-if="bars.length == 0" ng-cloak>
          <h4 ng-cloak> Sorry, Your requested file is not in our database. </h4>
        </div>
      </div>
    </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>