<div class="modal inmodal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
      		<div class="modal-body">
        		<p class="modal-title" id="exampleModalLabel">Ready to Leave?</p>
      			<h5>
      				Select "Sign out" below if you are ready to end your current session.
      			</h5>
      		</div>
	      <div class="modal-footer">
			<button class="btn btn-white" type="button" data-dismiss="modal">Cancel</button>
	        <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Sign out</a>
	    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	      		@csrf
	    	</form>
	      </div>
        </div>
    </div>
</div>