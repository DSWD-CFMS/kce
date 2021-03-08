@extends(Auth::check() ? 'layouts.dashboard' : 'layouts.app2')

@section('content')
<style type="text/css">
	/* Featurettes
	------------------------- */

	.featurette-divider {
	  margin: 5rem 0; /* Space out the Bootstrap <hr> more */
	}

	/* Thin out the marketing headings */
	.featurette-heading {
	  font-weight: 300;
	  line-height: 1;
	  letter-spacing: -.05rem;
	}

	@media (min-width: 40em) {
	  .featurette-heading {
	    font-size: 50px;
	  }
	}

	@media (min-width: 62em) {
	  .featurette-heading {
	    margin-top: 7rem;
	  }
	}
</style>
<div class="container" style="margin-top: 100px;">
	<!-- START THE FEATURETTES -->

    <div class="row featurette">
      <div class="col-sm-9">
        <h2 class="featurette-heading">What is Kalahi-CIDSS ?</h2>
	        <p class="lead">
	        	Kapit-Bisig Laban sa Kahirapan – Comprehensive Integrated Delivery of Social Service (KALAHI-CIDSS) is a community-driven development project implemented by the Department of Social Welfare and Development. Under KALAHI-CIDSS, communities and their Local Government Units (LGUs) are trained to choose, design and implement sub-projects that address their most pressing need. The project aims to reduce poverty by empowering communities and promoting good governance, through Provision of support for community projects and activities, and Encouraging local government responsiveness to community-identified development projects. The Project is being implemented as part of the department’s mission in pursuing poverty alleviation and empowerment of poor, vulnerable and disadvantaged communities. This is also in response to government’s social contract and key programs and strategies in the Philippine Development Plan for 2011-2016 in developing human resource through improved social services. CDD puts power back in the hands of the people by giving them the opportunity to make informed decision on locally identified options for development and manage resources to implement sub-projects that address needs identified by communities themselves.
	        </p>
    	</div>
		<div class="col-sm-3">
        	<img class="featurette-image img-fluid mx-auto" src="/images/for_about/kalahi.jpg" style="width: 100%; height: 100%; object-fit: contain;" alt="Generic placeholder image">
      	</div>
   	</div>
    
    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-sm-7">
        <h2 class="featurette-heading">Objectives of NCDDP</h2>
        <p class="lead">Community improvement, by involving communities in participatory planning, implementation, and management of local development activities. Improved local governance, by strengthening formal and informal institutions to become more inclusive, accountable, and affective. Poverty reduction, by promoting equitable access to basic services and inclusive growth.</p>
      </div>
      <div class="col-sm-5">
        <img class="featurette-image img-fluid mx-auto" src="/images/for_about/goal.png" style="width: 500px; height: 500px; object-fit: cover;" alt="Generic placeholder image">
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-sm-7 order-sm-2">
        <h2 class="featurette-heading">Who are eligible to participate in NCDDP? </h2>
        <p class="lead">
        	<i class="fa fa-check"></i> A 4th-6th class municipality with poverty incidence higher than the national average of 26.5% based on the 2009 small area estimates (SAE) of the National Statistical Coordination Board.
        </p>
        <p class="lead">
        	<i class="fa fa-check"></i> A 1st-3rd class municipality with 40% poverty incidence or higher.
        </p>
        <p class="lead">
        	<i class="fa fa-check"></i> A municipality affected by tropical storm Haiyan (local name: Yolanda) within an NCDDP province, regardless of poverty incidence.
        </p>
      </div>
      <div class="col-sm-5 order-sm-1">
        <img class="featurette-image img-fluid mx-auto" src="/images/for_about/checklist.png" style="width: 500px; height: 500px; object-fit: cover;" alt="Generic placeholder image">
      </div>
    </div>

    <hr class="featurette-divider">

	<!-- /END THE FEATURETTES -->
</div>
@endsection