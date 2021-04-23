<link href="{{ asset('dataTables/datatablesnew.min.css') }}" rel="stylesheet">
<link href="{{ asset('dataTables/w3.css') }}" rel="stylesheet">
<style>

.loading {
	animation: bounceIn 1300ms infinite
}

@keyframes bounceIn {
	from,20%,40%,60%,80%,
	to {animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);}
	0% {opacity: 0;transform: scale3d(0.3, 0.3, 0.3);}
	20% {transform: scale3d(1.1, 1.1, 1.1);}
	40% {transform: scale3d(0.9, 0.9, 0.9);}
	60% {opacity: 1;transform: scale3d(1.03, 1.03, 1.03);}
	80% {transform: scale3d(0.97, 0.97, 0.97);}
	to {opacity: 1;transform: scale3d(1, 1, 1);}
}
*{
	font-size: 12px
}

</style>
<div id='content' style='padding:20px;margin:5px;border:1px solid #f5f5f5;'>
<h4 class='text-center loading'><strong style="color:black;font-size: 20px;">Retrieving Data from the Server...</strong><br><br><i class="fa fa-database  fa-3x fa-fw" style="color:#86ebb8;font-size: 8x;"></i></h4>   
</div>

<div id="id01" class="x-modal">
	<div class="x-modal-content x-round-large">
		<div class="x-container x-padding">
			<span onclick="$ID('id01').style.display='none'"
			class="x-button x-display-topright x-round-large x-red">&times;</span>
			<h4 class="x-text-blue">Details for SP # : <b id="sp_id_v"></b></h4>
			<div class="x-row x-container">
				<div class="x-container x-col l4 s4 m4">
					<h4 class="x-row">Date Started</h4>
					<div class="x-row">
						<input type="date" class="x-col s7 m7 l7 x-input x-border" name="started_date" id="started_date">
						<button class="x-col s5 m5 l5 x-btn x-blue" onclick="set_start_date()">Set Date</button>
					</div>
				</div>
			</div>
			<hr>
			<div class="x-container x-padding x-row">
				<!-- <button class="x-btn x-orange">RFR Tracking</button> -->
				<!-- <button class="x-btn x-green">SPCR Tracking</button> -->
		      	<button type="button" style="border-radius: 100px;" class="btn btn-outline-primary mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched($ID('sp_id_v').innerHTML)"> <i class="fa fa-history"></i> View Track history </button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="{{ asset('/dataTables/datatablesnew.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/dataTables/Brorn.min.js') }}"></script>
<script>


function init(){
	$.ajax({
		type:'GET',
		url:'new_module_content_table',
		success: function(data){
			$('#content').html(data);
			$('#table_details').DataTable({
				 'processing': true,
				 'dom': 'lBfrtip',
				 aLengthMenu: [
						[ 10, 25, 50, 100, 200, 500, 1000, -1],
						[ 10, 25, 50, 100, 200, 500, 1000, "All"]
					],
					iDisplayLength: 10,
				 'buttons': [
					{
						extend: 'collection',
						text: 'Export to...',
						buttons: [
							'copy',
							'excel',
							'csv',
							'pdf',
							'print'
						]
					}
				]
			});
		}
	});	
}

init();

function det_modal(res){
	$ID('sp_id_v').innerHTML = res
	$ID('id01').style.display='block'
	// $send({
	// 	action:'/rpmo/routes/get_sp_details',
	// 	data : $DATA({'data':res}),
	// 	method : POST,
	// 	_async : true,
	// 	headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	// 	func : function(res){
	// 		$print(res)
	// 	}
	// })
}

function set_start_date(){
	var c = confirm('Are You Sure?');
	if(c){
		spid = $ID('sp_id_v').innerHTML;
		date_start = $ID('started_date').value;
		$print(date_start);
		$send({
			action:'/rpmo/routes/set_date_start',
			data : $DATA({
				'date':date_start,
				'id':spid,
				}),
			method : POST,
			_async : true,
			headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			func : function(res){
				// location.reload()
				alert(res)
				init();
				$ID('id01').style.display='none';

			}
		})
	}
	
}



</script>