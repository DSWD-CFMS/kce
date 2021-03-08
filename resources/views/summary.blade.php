@extends('layouts.app2')

@section('content')

<style type="text/css">
	.clickable_thead:hover{
		color: #fff;
		font-weight: bold;
		font-size: 1.2em;
	}

</style>
<div class="container-fluid" style="padding-top: 100px;" ng-init="show_summary()">
    <section class="row justify-content-center">
        <div class="col-lg-12">
            <h1 class="font-weight-bold">Summary 2020</h1>
			<h3 class="font-weight-light">Target Completion vs Actual Completion</h3>
        </div>
		
        <div class="col-lg-6">
       		<div class="table-responsive">
       			<table class="table table-bordered table-sm">
       				<thead class="thead-dark">
       					<tr class="text-info">
	       					<th>MODALITY</th>
	       					<th></th>
	       					<th>Jan</th>
	       					<th>Feb</th>
	       					<th>Mar</th>
	       					<th>Apr</th>
	       					<th>May</th>
	       					<th>Jun</th>
	       					<th>Jul</th>
	       					<th>Aug</th>
	       					<th>Sept</th>
	       					<th>Oct</th>
	       					<th>Nov</th>
	       					<th>Dec</th>
       					</tr>
       				</thead>
       				<tbody>
       					<tr>
	       					<th rowspan="2">
	       						<h3 class="text-success my-0 font-weight-bold">NCDDP</h3>
	       						<h4 class="mt-0 font-weight-light text-success">2020</h4>
	       						<p class="mb-0 font-weight-light">TOTAL SP</p>
	       						<span class="font-weight-bold" style="font-size: 1.2em;">202</span>
	       					</th>
	       					<th class="text-warning">
	       						Target
	       					</th>
	                        <td>
	                        	<span ng-if="target_ncddp.January[0] == 'undefined' || target_ncddp.January[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.January[0] != 'undefined' || target_ncddp.January[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.January[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.Feruary[0] == 'undefined' || target_ncddp.Feruary[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.Feruary[0] != 'undefined' || target_ncddp.Feruary[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.Feruary[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.March[0] == 'undefined' || target_ncddp.March[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.March[0] != 'undefined' || target_ncddp.March[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.March[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.April[0] == 'undefined' || target_ncddp.April[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.April[0] != 'undefined' || target_ncddp.April[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.April[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.May[0] == 'undefined' || target_ncddp.May[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.May[0] != 'undefined' || target_ncddp.May[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.May[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.June[0] == 'undefined' || target_ncddp.June[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.June[0] != 'undefined' || target_ncddp.June[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.June[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.July[0] == 'undefined' || target_ncddp.July[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.July[0] != 'undefined' || target_ncddp.July[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.July[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.August[0] == 'undefined' || target_ncddp.August[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.August[0] != 'undefined' || target_ncddp.August[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.August[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.September[0] == 'undefined' || target_ncddp.September[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.September[0] != 'undefined' || target_ncddp.September[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.September[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.October[0] == 'undefined' || target_ncddp.October[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.October[0] != 'undefined' || target_ncddp.October[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.October[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.November[0] == 'undefined' || target_ncddp.November[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.November[0] != 'undefined' || target_ncddp.November[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.November[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ncddp.December[0] == 'undefined' || target_ncddp.December[0] == NULL">0</span>
	                        	<span ng-if="target_ncddp.December[0] != 'undefined' || target_ncddp.December[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ncddp.December[0]"></span>
	                        	</span>
	                        </td>
       					</tr>
       					<tr>
	       					<th class="text-warning">
	       						Actual
	       					</th>
	                        <td>
	                        	<span ng-if="actual_ncddp.January[0] == 'undefined' || actual_ncddp.January[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.January[0] != 'undefined' || actual_ncddp.January[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.January[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.Feruary[0] == 'undefined' || actual_ncddp.Feruary[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.Feruary[0] != 'undefined' || actual_ncddp.Feruary[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.Feruary[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.March[0] == 'undefined' || actual_ncddp.March[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.March[0] != 'undefined' || actual_ncddp.March[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.March[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.April[0] == 'undefined' || actual_ncddp.April[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.April[0] != 'undefined' || actual_ncddp.April[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.April[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.May[0] == 'undefined' || actual_ncddp.May[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.May[0] != 'undefined' || actual_ncddp.May[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.May[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.June[0] == 'undefined' || actual_ncddp.June[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.June[0] != 'undefined' || actual_ncddp.June[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.June[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.July[0] == 'undefined' || actual_ncddp.July[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.July[0] != 'undefined' || actual_ncddp.July[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.July[0]"></span>
	                        	</span>	
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.August[0] == 'undefined' || actual_ncddp.August[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.August[0] != 'undefined' || actual_ncddp.August[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.August[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.September[0] == 'undefined' || actual_ncddp.September[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.September[0] != 'undefined' || actual_ncddp.September[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.September[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.October[0] == 'undefined' || actual_ncddp.October[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.October[0] != 'undefined' || actual_ncddp.October[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.October[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.November[0] == 'undefined' || actual_ncddp.November[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.November[0] != 'undefined' || actual_ncddp.November[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.November[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ncddp.December[0] == 'undefined' || actual_ncddp.December[0] == NULL">0</span>
	                        	<span ng-if="actual_ncddp.December[0] != 'undefined' || actual_ncddp.December[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ncddp.December[0]"></span>
	                        	</span>
	                        </td>
       					</tr>
       				</tbody>
       			</table>
       		</div>
		</div>
        <div class="col-lg-6">
       		<div class="table-responsive">
       			<table class="table table-bordered table-sm">
       				<thead class="thead-dark">
       					<tr class="text-info">
	       					<th>MODALITY</th>
	       					<th></th>
	       					<th>Jan</th>
	       					<th>Feb</th>
	       					<th>Mar</th>
	       					<th>Apr</th>
	       					<th>May</th>
	       					<th>Jun</th>
	       					<th>Jul</th>
	       					<th>Aug</th>
	       					<th>Sept</th>
	       					<th>Oct</th>
	       					<th>Nov</th>
	       					<th>Dec</th>
       					</tr>
       				</thead>
       				<tbody>
       					<tr>
	       					<th rowspan="2">
	       						<h3 class="text-danger my-0 font-weight-bold">IPCDD</h3>
	       						<h4 class="mt-0 font-weight-light text-danger">2020</h4>
	       						<p class="mb-0 font-weight-light">TOTAL SP</p>
	       						<span class="font-weight-bold" style="font-size: 1.2em;">74</span>
	       					</th>
	       					<th class="text-warning">
	       						Target
	       					</th>
	                        <td>
	                        	<span ng-if="target_ipcdd.January[0] == 'undefined' || target_ipcdd.January[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.January[0] != 'undefined' || target_ipcdd.January[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.January[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.Feruary[0] == 'undefined' || target_ipcdd.Feruary[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.Feruary[0] != 'undefined' || target_ipcdd.Feruary[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.Feruary[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.March[0] == 'undefined' || target_ipcdd.March[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.March[0] != 'undefined' || target_ipcdd.March[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.March[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.April[0] == 'undefined' || target_ipcdd.April[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.April[0] != 'undefined' || target_ipcdd.April[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.April[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.May[0] == 'undefined' || target_ipcdd.May[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.May[0] != 'undefined' || target_ipcdd.May[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.May[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.June[0] == 'undefined' || target_ipcdd.June[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.June[0] != 'undefined' || target_ipcdd.June[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.June[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.July[0] == 'undefined' || target_ipcdd.July[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.July[0] != 'undefined' || target_ipcdd.July[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.July[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.August[0] == 'undefined' || target_ipcdd.August[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.August[0] != 'undefined' || target_ipcdd.August[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.August[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.September[0] == 'undefined' || target_ipcdd.September[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.September[0] != 'undefined' || target_ipcdd.September[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.September[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.October[0] == 'undefined' || target_ipcdd.October[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.October[0] != 'undefined' || target_ipcdd.October[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.October[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.November[0] == 'undefined' || target_ipcdd.November[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.November[0] != 'undefined' || target_ipcdd.November[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.November[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="target_ipcdd.December[0] == 'undefined' || target_ipcdd.December[0] == NULL">0</span>
	                        	<span ng-if="target_ipcdd.December[0] != 'undefined' || target_ipcdd.December[0] != NULL">
	                        		<span class="text-warning" ng-bind="target_ipcdd.December[0]"></span>
	                        	</span>
	                        </td>
       					</tr>
       					<tr>
	       					<th class="text-warning">
	       						Actual
	       					</th>
	                        <td>
	                        	<span ng-if="actual_ipcdd.January[0] == 'undefined' || actual_ipcdd.January[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.January[0] != 'undefined' || actual_ipcdd.January[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.January[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.Feruary[0] == 'undefined' || actual_ipcdd.Feruary[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.Feruary[0] != 'undefined' || actual_ipcdd.Feruary[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.Feruary[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.March[0] == 'undefined' || actual_ipcdd.March[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.March[0] != 'undefined' || actual_ipcdd.March[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.March[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.April[0] == 'undefined' || actual_ipcdd.April[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.April[0] != 'undefined' || actual_ipcdd.April[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.April[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.May[0] == 'undefined' || actual_ipcdd.May[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.May[0] != 'undefined' || actual_ipcdd.May[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.May[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.June[0] == 'undefined' || actual_ipcdd.June[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.June[0] != 'undefined' || actual_ipcdd.June[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.June[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.July[0] == 'undefined' || actual_ipcdd.July[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.July[0] != 'undefined' || actual_ipcdd.July[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.July[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.August[0] == 'undefined' || actual_ipcdd.August[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.August[0] != 'undefined' || actual_ipcdd.August[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.August[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.September[0] == 'undefined' || actual_ipcdd.September[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.September[0] != 'undefined' || actual_ipcdd.September[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.September[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.October[0] == 'undefined' || actual_ipcdd.October[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.October[0] != 'undefined' || actual_ipcdd.October[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.October[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.November[0] == 'undefined' || actual_ipcdd.November[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.November[0] != 'undefined' || actual_ipcdd.November[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.November[0]"></span>
	                        	</span>
	                        </td>
	                        <td>
	                        	<span ng-if="actual_ipcdd.December[0] == 'undefined' || actual_ipcdd.December[0] == NULL">0</span>
	                        	<span ng-if="actual_ipcdd.December[0] != 'undefined' || actual_ipcdd.December[0] != NULL">
	                        		<span class="text-warning" ng-bind="actual_ipcdd.December[0]"></span>
	                        	</span>
	                        </td>
       					</tr>
       				</tbody>
       			</table>
       		</div>
        </div>
    </section>

    <section class="row justify-content-center">
	    <div class="col-lg-6">
	 		<h3 class="text-success">NCDDP 2020</h3>
	 		<div class="table-responsive">
	 			<table class="table table-bordered table-sm">
	 				<thead style="font-size: .9em; cursor: pointer;">
	 					<tr>
		 					<th rowspan="2">Municipality</th>
		 					<th rowspan="2">Total No. of SP's</th>
		 					<th colspan="4">Weighted Percentage</th>
		 					<th rowspan="2">Remarks</th>
	 					</tr>
	 					<tr>
		 					<th class="clickable_thead" colspan="1" style="background: #ed5565;" ng-click="zero_percent(3,0)">0%</th>
		 					<th class="clickable_thead" colspan="1" style="background: #f8b41b;" ng-click="zero_percent(3,1)">0.01%-59.99%</th>
		 					<th class="clickable_thead" colspan="1" style="background: #f88b1b;" ng-click="zero_percent(3,2)">60%-99.99%</th>
		 					<th class="clickable_thead" colspan="1" style="background: #5ed267;" ng-click="zero_percent(3,3)">100%</th>
	 					</tr>
	 				</thead>
	 				<tbody>
	 					<tr ng-repeat="(key, value) in group_per_muni_ncddp">
	 						<td ng-bind="key"></td>
	 						<td ng-bind="value.length">12</td>
	 						<td class="bg-danger">
	 							<span class="level0_ncddp" ng-bind="level0_ncddp(value)"></span>
	 						</td>
	 						<td  style="background: #f8b41b;">
	 							<span class="level1_ncddp" ng-bind="level1_ncddp(value)"></span>
	 						</td>
	 						<td  style="background: #f88b1b;">
	 							<span class="level2_ncddp" ng-bind="level2_ncddp(value)"></span>
	 						</td>
	 						<td  style="background: #5ed267;">
	 							<span class="level3_ncddp" ng-bind="level3_ncddp(value)"></span>
	 						</td>
	 						<td>NONE</td>
	 					</tr>
	 				</tbody>
					<tfoot>
	 					<tr class="bg-info">
	 						<td>TOTAL</td>
	 						<td ng-bind="total_ncddp"></td>
	 						<td ng-bind="get_total_level0('level0_ncddp')"></td>
	 						<td ng-bind="get_total_level0('level1_ncddp')"></td>
	 						<td ng-bind="get_total_level0('level2_ncddp')"></td>
	 						<td ng-bind="get_total_level0('level3_ncddp')"></td>
	 						<td></td>
	 					</tr>
	 					<tr class="bg-primary">
	 						<td colspan="7" class="text-light">
	 							<h5 class="font-weight-bold">TOTAL WEIGHTED PERCENTAGE</h5>
	 							<!-- <h2 class="font-weight-light text-right my-0" ng-bind="(((get_total_level0('level3_ncddp') / total_ncddp) * 100) | number:2) +'%'"></h2> -->
	 							<h2 class="font-weight-light text-right my-0" ng-bind="((weighted_ncddp_percetage) | number:2) +'%'"></h2>
	 						</td>
	 					</tr>
					</tfoot>
	 			</table>
	 		</div>

	 		<div class="col-lg-12">
	 			<h2 class="my-0">Cycle and Batch</h2>
	 			<div class="row">
                    <div class="col mx-1 widget style1 yellow-bg" ng-repeat="(key, value) in ncddp_per_cb">
                        <div class="row vertical-align">
                            <div class="col-4">
								C<span ng-bind="key"></span>
                            </div>
                            <div class="col-8 text-right">
			 					<span class="font-weight-bold">
									<h2 ng-bind="value.length +' SP'"></h2>
			 					</span> 
                            </div>
                        </div>
                    </div>
	 			</div>
	 		</div>	 		
	    </div>	

	    <div class="col-lg-6">
	 		<h3 class="text-danger">IPCDD 2020</h3>
	 		<div class="table-responsive">
	 			<table class="table table-bordered table-sm">
	 				<thead style="font-size: .9em; cursor: pointer;">
	 					<tr>
		 					<th rowspan="2">Municipality</th>
		 					<th rowspan="2">Total No. of SP's</th>
		 					<th colspan="4">Weighted Percentage</th>
		 					<th rowspan="2">Remarks</th>
	 					</tr>
	 					<tr>
		 					<th class="clickable_thead" colspan="1" style="background: #ed5565;" ng-click="zero_percent(4,0)">0%</th>
		 					<th class="clickable_thead" colspan="1" style="background: #f8b41b;" ng-click="zero_percent(4,1)">0.01%-59.99%</th>
		 					<th class="clickable_thead" colspan="1" style="background: #f88b1b;" ng-click="zero_percent(4,2)">60%-99.99%</th>
		 					<th class="clickable_thead" colspan="1" style="background: #5ed267;" ng-click="zero_percent(4,3)">100%</th>
	 					</tr>
	 				</thead>
	 				<tbody>
	 					<tr ng-repeat="(key, value) in group_per_muni_ipccd">
	 						<td ng-bind="key"></td>
	 						<td ng-bind="value.length">12</td>
	 						<td class="bg-danger">
	 							<span class="level0_class" ng-bind="level0(value)"></span>
	 						</td>
	 						<td  style="background: #f8b41b;">
	 							<span class="level1_class" ng-bind="level1(value)"></span>
	 						</td>
	 						<td  style="background: #f88b1b;">
	 							<span class="level2_class" ng-bind="level2(value)"></span>
	 						</td>
	 						<td  style="background: #5ed267;">
	 							<span class="level3_class" ng-bind="level3(value)"></span>
	 						</td>
	 						<td>NONE</td>
	 					</tr>
	 					<tr class="bg-info">
	 						<td>TOTAL</td>
	 						<td ng-bind="total_ipcddd"></td>
	 						<td ng-bind="get_total_level0('level0_class')"></td>
	 						<td ng-bind="get_total_level0('level1_class')"></td>
	 						<td ng-bind="get_total_level0('level2_class')"></td>
	 						<td ng-bind="get_total_level0('level3_class')"></td>
	 						<td></td>
	 					</tr>
	 					<tr class="bg-primary">
	 						<td colspan="7" class="text-light">
	 							<h5 class="font-weight-bold">TOTAL WEIGHTED PERCENTAGE</h5>
	 							<!-- <h2 class="font-weight-light text-right my-0" ng-bind="(((get_total_level0('level3_class') / total_ipcddd) * 100) | number:2) +'%'"></h2> -->
	 							<h2 class="font-weight-light text-right my-0" ng-bind="((weighted_ipccdd_percetage) | number:2) +'%'"></h2>
	 						</td>
	 					</tr>
	 				</tbody>
	 			</table>
	 		</div>

	 		<div class="col-lg-12">
	 			<h2 class="my-0">Cycle and Batch</h2>
	 			<div class="row">
                    <div class="col mx-1 widget style1 yellow-bg" ng-repeat="(key, value) in ipcdd_per_cadt">
                        <div class="row vertical-align">
                            <div class="col-4">
									C<span ng-bind="key"></span> <br>
									<span ng-repeat="(key1, value2) in value">
			 						B<span ng-bind="key1"></span>
                            </div>
                            <div class="col-8 text-right">
			 					<span class="font-weight-bold">
				 					<span ng-repeat="(key1, value2) in value">
				 						<h2 ng-bind="value2.length +' SP'"></h2>
				 					</span>
			 					</span> 
                            </div>
                        </div>
                    </div>
	 			</div>
	 		</div>
	    </div>
    </section>
@include('summary_modal')
</div>
@endsection


