<div class="row wrapper animated fadeInRight ecommerce px-0 pb-0 ">
  <div class="col-lg-12 my-2">
    <label class="text-muted"><small size="1"><span ng-if="sp_per_modality_data_all_sp_logs.from!=null" ng-bind="'Showing records '+sp_per_modality_data_all_sp_logs.from+'-'+sp_per_modality_data_all_sp_logs.to+' out of '+sp_per_modality_data_all_sp_logs.total"></span></small></label>
    <!-- <label class="text-muted"><small> Displaying 10 out of 1080 items </small></label> -->
      <ul class="pagination">

          <!-- Pag previous sa page  -->
      <li class="page-item disabled" ng-if="sp_per_modality_data_all_sp_logs.current_page == 1">
        <a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a>
      </li>
      <li class="page-item" ng-if="sp_per_modality_data_all_sp_logs.current_page!=1" ng-click="Previous_Pagination(sp_per_modality_data_all_sp_logs.prev_page_url)"><a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a></li>

      <!-- Pag adto sa first page -->
      <li class="page-item" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == 1 || sp_per_modality_data_all_sp_logs.current_page == 2 || sp_per_modality_data_all_sp_logs.current_page == 3 || sp_per_modality_data_all_sp_logs.last_page> 3 && sp_per_modality_data_all_sp_logs.last_page < 6}" ng-click="Skip_To_Page(sp_per_modality_data_all_sp_logs.path,1)">
      <a style="text-transform: none;" class="page-link text-secondary" href="">1</a>
      </li>

      <!-- Mag add ug (...) if ang current page is 4 pataas -->
      <li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == 1 || sp_per_modality_data_all_sp_logs.current_page == 2 || sp_per_modality_data_all_sp_logs.current_page == 3 ||sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}">
        <a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
      </li>   

      <!-- Number of Pages -->
      <li ng-repeat="x in [].constructor(sp_per_modality_data_all_sp_logs.last_page) track by $index" ng-click="Skip_To_Page(sp_per_modality_data_all_sp_logs.path,$index+1)">
        <a style="text-transform: none;" ng-class="{'bg-success active text-light': $index+1 == sp_per_modality_data_all_sp_logs.current_page, 'invisible' : sp_per_modality_data_all_sp_logs.current_page+1 < $index && $index > 5 || sp_per_modality_data_all_sp_logs.current_page - 5 >$index && $index <sp_per_modality_data_all_sp_logs.last_page-5}"  class="page-link text-secondary" href="" ng-bind="$index+1"></a>
      </li>

      <!-- Pag add ug (...) -->
      <li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-1 || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-2||sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}">
      <a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
      </li>

      <!-- Pag adto sa last page last page -->
      <li class="page-item" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-1 || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-2 || sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}" ng-click="Skip_To_Page(sp_per_modality_data_all_sp_logs.last_page)">
      <a style="text-transform: none;" class="page-link text-secondary" href="" ng-bind="sp_per_modality_data_all_sp_logs.last_page"></a>
      </li>

      <!-- Pag Next sa Pages -->
      <li class="page-item">
        <a style="text-transform: none;" class="page-link text-secondary" href="" ng-click="Next_Pagination(sp_per_modality_data_all_sp_logs.next_page_url)">Next</a></li>
      </ul>
  </div>
</div>

<div class="wrapper wrapperr-content animated fadeInRight ecommerce px-0 pb-0">
  <div class="table-responsive" style="height: 30px;">
    <table class="table table-bordered1" style="font-size: 9px;"> 
      <thead class="thead-dark">
        <tr>
          <th scope="col">SP TITLE</th>
          <th scope="col">PROVINCE</th>
          <th scope="col">MUNICIPALITY</th>
          <th scope="col">BARANGAY</th>
          <th scope="col">LOTS</th>
          <th scope="col">IMPLEMENTATION</th>
          <th scope="col">ACTION</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="table-responsive" style="height: 400px;">
    <table class="table table-bordered1 table-hover" style="font-size: 9px;"> 
      <tbody style="overflow-y: auto !important;">
        <tr ng-repeat="all_data in bars = (sp_per_modality_data_all_sp_logs.data) track by $index">
          <td ng-bind="all_data.sp_title"></td>
          <td ng-bind="all_data.sp_province | uppercase"></td>
          <td ng-bind="all_data.sp_municipality | uppercase"></td>
          <td ng-bind="all_data.sp_brgy | uppercase"></td>
          <td ng-bind="all_data.sp_pmr.length"></td>
          <td ng-bind="all_data.sp_implementation"></td>
          <td>
            <button class="btn btn-outline-primary rounded-0" ng-click="fetch_specific_sp_pmr_data(all_data.sp_id,all_data,1)"> View <i class="fa fa-eye"></i>
            </button>
            <button class="btn btn-outline-success rounded-0" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_pmr_modal" ng-click="fetch_specific_sp_pmr_data(all_data.sp_id,all_data,0)"> Create PMR <i class="fa fa-plus"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
  
@include('user_procurement.export_sp')
@include('user_procurement.export_pmr')


