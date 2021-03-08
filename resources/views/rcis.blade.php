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



/* CALENDAR */

#calendar {
  -webkit-transform: translate3d(0, 0, 0);
  -moz-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
  /*width: 420px;*/
  /*width: 700px;*/
  width: 800px;
  margin: 0 auto;
  /*height: 570px;*/
  /*overflow: hidden;*/
}

.header {
  height: 50px;
  width: 800px;
  background: rgba(255, 255, 255, 1);
  text-align: center;
  position:relative;
  z-index: 100;
}

.header h1 {
  margin: 0;
  padding: 0;
  font-size: 28px;
  line-height: 50px;
  font-weight: 100;
  letter-spacing: 1px;
  color: #3490dc;
}

.left, .right {
  position: absolute;
  width: 0px;
  height: 0px;
  border-style: solid;
  top: 50%;
  margin-top: -7.5px;
  cursor: pointer;
}

.left {
  border-width: 7.5px 10px 7.5px 0;
  border-color: transparent rgba(160, 159, 160, 1) transparent transparent;
  left: 20px;
}

.right {
  border-width: 7.5px 0 7.5px 10px;
  border-color: transparent transparent transparent rgba(160, 159, 160, 1);
  right: 20px;
}

.month {
  /*overflow: hidden;*/
  opacity: 0;
}

.month.new {
  -webkit-animation: fadeIn 1s ease-out;
  opacity: 1;
}

.month.in.next {
  -webkit-animation: moveFromTopFadeMonth .4s ease-out;
  -moz-animation: moveFromTopFadeMonth .4s ease-out;
  animation: moveFromTopFadeMonth .4s ease-out;
  opacity: 1;
}

.month.out.next {
  -webkit-animation: moveToTopFadeMonth .4s ease-in;
  -moz-animation: moveToTopFadeMonth .4s ease-in;
  animation: moveToTopFadeMonth .4s ease-in;
  opacity: 1;
}

.month.in.prev {
  -webkit-animation: moveFromBottomFadeMonth .4s ease-out;
  -moz-animation: moveFromBottomFadeMonth .4s ease-out;
  animation: moveFromBottomFadeMonth .4s ease-out;
  opacity: 1;
}

.month.out.prev {
  -webkit-animation: moveToBottomFadeMonth .4s ease-in;
  -moz-animation: moveToBottomFadeMonth .4s ease-in;
  animation: moveToBottomFadeMonth .4s ease-in;
  opacity: 1;
}

.week {
 background: #f8fafc;
}

.day {
  display: inline-block;
  /*width: 60px;*/
  width: 114.2px;
  /*padding: 10px;*/
  padding: 15px;
  text-align: center;
  vertical-align: top;
  cursor: pointer;
  background: #ffffff;
  position: relative;
  z-index: 100;
}

.day.other {
 color: rgba(255, 255, 255, .3);
}

.day.today {
  color: rgba(156, 202, 235, 1);
}

.day-name {
  font-size: 9px;
  text-transform: uppercase;
  margin-bottom: 5px;
  color: #535454;
  letter-spacing: .7px;
}

.day-number {
  font-size: 24px;
  letter-spacing: 1.5px;
}

.day .day-events {
  list-style: none;
  margin-top: 3px;
  text-align: center;
  height: 12px;
  line-height: 6px;
  overflow: hidden;
}

.day .day-events span {
  vertical-align: top;
  display: inline-block;
  padding: 0;
  margin: 0;
  width: 5px;
  height: 5px;
  line-height: 5px;
  margin: 0 1px;
}

.blue { background: rgba(156, 202, 235, 1); }
.orange { background: rgba(247, 167, 0, 1); }
.green { background: rgba(153, 198, 109, 1); }
.yellow { background: rgba(249, 233, 0, 1); }

.details {
  position: relative;
  /*width: 420px;*/
  width: 800px;
  height: 75px;
  background: rgba(164, 164, 164, 1);
  margin-top: 5px;
  border-radius: 4px;
}

.details.in {
  -webkit-animation: moveFromTopFade .5s ease both;
  -moz-animation: moveFromTopFade .5s ease both;
  animation: moveFromTopFade .5s ease both;
}

.details.out {
  -webkit-animation: moveToTopFade .5s ease both;
  -moz-animation: moveToTopFade .5s ease both;
  animation: moveToTopFade .5s ease both;
}

.arrow {
  position: absolute;
  top: -5px;
  left: 50%;
  margin-left: 17px;
  width: 0px;
  height: 0px;
  border-style: solid;
  border-width: 0 5px 5px 5px;
  border-color: transparent transparent rgba(164, 164, 164, 1) transparent;
  transition: all 0.7s ease;
}

.events {
  height: 75px;
  padding: 7px 0;
  overflow-y: auto;
  overflow-x: hidden;
}

.events.in {
  -webkit-animation: fadeIn .3s ease both;
  -moz-animation: fadeIn .3s ease both;
  animation: fadeIn .3s ease both;
}

.events.in {
  -webkit-animation-delay: .3s;
  -moz-animation-delay: .3s;
  animation-delay: .3s;
}

.details.out .events {
  -webkit-animation: fadeOutShrink .4s ease both;
  -moz-animation: fadeOutShink .4s ease both;
  animation: fadeOutShink .4s ease both;
}

.events.out {
  -webkit-animation: fadeOut .3s ease both;
  -moz-animation: fadeOut .3s ease both;
  animation: fadeOut .3s ease both;
}

.event {
  font-size: 16px;
  line-height: 22px;
  letter-spacing: .5px;
  padding: 2px 16px;
  vertical-align: top;
}

.event.empty {
  color: #eee;
}

.event-category {
  height: 10px;
  width: 10px;
  display: inline-block;
  margin: 6px 0 0;
  vertical-align: top;
}

.event span {
  display: inline-block;
  padding: 0 0 0 7px;
  font-size: 12px;
}

.legend {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 30px;
  background: rgba(60, 60, 60, 1);
  line-height: 30px;

}

.entry {
  position: relative;
  padding: 0 0 0 25px;
  font-size: 13px;
  display: inline-block;
  line-height: 30px;
  background: transparent;
}

.entry:after {
  position: absolute;
  content: '';
  height: 5px;
  width: 5px;
  top: 12px;
  left: 14px;
}

.entry.blue:after { background: rgba(156, 202, 235, 1); }
.entry.orange:after { background: rgba(247, 167, 0, 1); }
.entry.green:after { background: rgba(153, 198, 109, 1); }
.entry.yellow:after { background: rgba(249, 233, 0, 1); }

/* Animations are cool!  */
@-webkit-keyframes moveFromTopFade {
  from { opacity: .3; height:0px; margin-top:0px; -webkit-transform: translateY(-100%); }
}
@-moz-keyframes moveFromTopFade {
  from { height:0px; margin-top:0px; -moz-transform: translateY(-100%); }
}
@keyframes moveFromTopFade {
  from { height:0px; margin-top:0px; transform: translateY(-100%); }
}

@-webkit-keyframes moveToTopFade {
  to { opacity: .3; height:0px; margin-top:0px; opacity: 0.3; -webkit-transform: translateY(-100%); }
}
@-moz-keyframes moveToTopFade {
  to { height:0px; -moz-transform: translateY(-100%); }
}
@keyframes moveToTopFade {
  to { height:0px; transform: translateY(-100%); }
}

@-webkit-keyframes moveToTopFadeMonth {
  to { opacity: 0; -webkit-transform: translateY(-30%) scale(.95); }
}
@-moz-keyframes moveToTopFadeMonth {
  to { opacity: 0; -moz-transform: translateY(-30%); }
}
@keyframes moveToTopFadeMonth {
  to { opacity: 0; -moz-transform: translateY(-30%); }
}

@-webkit-keyframes moveFromTopFadeMonth {
  from { opacity: 0; -webkit-transform: translateY(30%) scale(.95); }
}
@-moz-keyframes moveFromTopFadeMonth {
  from { opacity: 0; -moz-transform: translateY(30%); }
}
@keyframes moveFromTopFadeMonth {
  from { opacity: 0; -moz-transform: translateY(30%); }
}

@-webkit-keyframes moveToBottomFadeMonth {
  to { opacity: 0; -webkit-transform: translateY(30%) scale(.95); }
}
@-moz-keyframes moveToBottomFadeMonth {
  to { opacity: 0; -webkit-transform: translateY(30%); }
}
@keyframes moveToBottomFadeMonth {
  to { opacity: 0; -webkit-transform: translateY(30%); }
}

@-webkit-keyframes moveFromBottomFadeMonth {
  from { opacity: 0; -webkit-transform: translateY(-30%) scale(.95); }
}
@-moz-keyframes moveFromBottomFadeMonth {
  from { opacity: 0; -webkit-transform: translateY(-30%); }
}
@keyframes moveFromBottomFadeMonth {
  from { opacity: 0; -webkit-transform: translateY(-30%); }
}

@-webkit-keyframes fadeIn  {
  from { opacity: 0; }
}
@-moz-keyframes fadeIn  {
  from { opacity: 0; }
}
@keyframes fadeIn  {
  from { opacity: 0; }
}

@-webkit-keyframes fadeOut  {
  to { opacity: 0; }
}
@-moz-keyframes fadeOut  {
  to { opacity: 0; }
}
@keyframes fadeOut  {
  to { opacity: 0; }
}

@-webkit-keyframes fadeOutShink  {
  to { opacity: 0; padding: 0px; height: 0px; }
}
@-moz-keyframes fadeOutShink  {
  to { opacity: 0; padding: 0px; height: 0px; }
}
@keyframes fadeOutShink  {
  to { opacity: 0; padding: 0px; height: 0px; }
}

#myTab{
  position: sticky;
}
.tab-content{
  height: 550px;
  overflow-y: auto;
}

</style>

<div class="container" style="padding-top: 100px;">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="announcements-tab" data-toggle="tab" href="#announcements" role="tab" aria-controls="announcements" aria-selected="true">Announcements <i class="fa fa-bullhorn"></i></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="whereabouts-tab" data-toggle="tab" href="#whereabouts" role="tab" aria-controls="whereabouts" aria-selected="false">Whereabouts <i class="fa fa-location-arrow"></i></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="rcis-tab" data-toggle="tab" href="#rcis" role="tab" aria-controls="rcis" aria-selected="false">RCIS <i class="fa fa-binoculars"></i> </a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <!-- Announcements -->
    <div class="tab-pane fade show pt-5 active" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
      <div class="media">
        <img src="{{ asset('images/profile.jpg') }}" style="width: 60px; height: 60px; border-radius: 100px;" class="align-self-end mr-3" alt="...">
        <div class="media-body">
          <h5 class="my-0"><span>Louie Tantoy, AA 2</span></h5>
          <small>Tuesday & Wednesday January 14-15, 2020</small>
          <p class="my-0">
            We will be having our KALAHI-CIDSS NCDDP Year-End Program Implementation Review
          </p>
          <hr>
        </div>
      </div>
      <hr>

      <div class="media">
        <img src="{{ asset('images/profile.jpg') }}" style="width: 60px; height: 60px; border-radius: 100px;" class="align-self-end mr-3" alt="...">
        <div class="media-body">
          <h5 class="my-0"><span>Louie Tantoy, AA 2</span></h5>
          <small>Wednesday November 10, 2019</small>
          <p class="my-0">
            We will be having our KC Engineering Christmas party @Amontay Beach Resort. Gift amount shall be a minimum of 500.00 Php.
          </p>
          <hr>
          <p class="mb-0"><b>Note:</b> Hawaian Theme, December 10-11, 2019</p>
        </div>
      </div>
      <hr>
    </div>

    <!-- Whereabouts -->
    <div class="tab-pane fade" id="whereabouts" role="tabpanel" aria-labelledby="whereabouts-tab">
      <div class="container-fluid mt-2">
        @verbatim
          <div class="row justify-content-center" ng-init="get_whereabouts()" ng-cloak>
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-5">
                  <input type="text" class="form-control" aria-describedby="search_employee" placeholder="Search..."  ng-model="search_data_wabouts.$">
                </div>

                <div class="row justify-content-center" style="height: 455px;overflow-y: auto;">
                  <div class="col-lg-12 text-center" ng-if="whereabouts_data.length == 0">
                    <span class="text-danger">
                      No approved travel orders as of the moment...
                    </span>
                  </div>
                  <div class="col-lg-12" ng-if="whereabouts_data.length > 0">
                    <div class="media mb-3 pb-2" style="border-bottom: solid 1px #f8b41b;" ng-repeat="all_data in bars = (whereabouts_data | filter: search_data_wabouts.$)">
                      <img class="mr-3" src="/images/profile.jpg" style="object-fit: cover; width: 40px; height: 40px; border-radius: 50px;" alt="Generic placeholder image">
                        <div class="media-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="mt-0" ng-bind="(all_data.name)"> Jovenal L. Bernat </h5>
                              <span ng-bind="all_data.position"></span> <br>
                              <span ng-bind="all_data.place"></span> <br>
                              <span ng-bind="all_data.dateFrom | date:'fullDate'"></span> - <span ng-bind="all_data.dateTo | date:'fullDate'"></span>
                            </div>

                            <div class="col">
                              <small class="font-weight-bold text-warning">Purpose</small> <br>
                              <span ng-bind="all_data.purpose"></span> <br>
                              <small class="font-weight-bold text-warning">Status</small> <br>
                              <span ng-bind="all_data.status | uppercase"></span> <br>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        @endverbatim
      </div>
    </div>

    <!-- RCIS -->
    <div class="tab-pane fade" id="rcis" role="tabpanel" aria-labelledby="rcis-tab" style="overflow-x: hidden;">
      <div class="row featurette">
        <div class="col-sm-6">
          <h2 class="featurette-heading">COMMUNITY MANAGED IMPLEMENTATION ACCOMPLISHMENT <br>
            <b class="text-primary">JULY TO DECEMBER 2018</b>
          </h2>
          <h4>Community Managed Implementation all throughout the second semester for</h4>
          <small></small>
            <p class="lead">
              <hr>
              <ul>
                <li>293 (batch 1- cycle 3 and batch 2- cycle 2) of 46 prioritized Sub-Projects.</li>
                <li>Remaining 3 And Additional 23 CCL Projects.</li>
                <li>Batch 1 Panama IP-CDD 19 Sub-Projects.</li>
                <li>Pre-Engineering Activity of Makilahok Pilot Municipalities.</li>
                <li>Pre-Engineering Activity of Batch 2 Pamana IP-CDD Areas.</li>
              </ul>
            </p>
        </div>
        <div class="col-sm-6 my-0 py-0 px-0">
            <img class="featurette-image" src="/images/for_about/berns_white.png" style="width: 80%; object-fit: cover;" alt="Generic placeholder image">
          </div>
      </div>
      
      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-sm-7">
          <h2 class="featurette-heading">How we Illustrate the Drawing Board</h2>
          <br>

          <h5 class="text-info">It bears a color of success</h5>
          <p class="lead">
            <ul>
              <li>Success to all prioritized areas were able to implement (293, ccl and Pamana IP-CDD).</li>
              <li>Success for The Conduct of All-Out Project Monitoring and Supervision.</li>
              <li>Success for the sub-project completion in accordance to duration.</li>
              <li>Success for the output of technical documents for the Makilahok and Pamana IP-CDD.</li>
              <li>Success for the conduct of capacity building (project sustainability and procurement) to proponent communities and program awareness to partner stakeholders.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">But behind the color of success lies the blur and patch of the 4 corners of implementation:</h5>
          <p class="lead">
            <ul>
              <li>The Setback on The Compliance and Submission of Requisite Documents Prior To Project Implementation.</li>
              <li>Beyond the Control Situation During Pre And On-Site Stage of Implementation.</li>
              <li>The Word Completion Is Not as Simple in The Actual Phase of Construction</li>
              <li>Reliance and Facilitation of Kc Staff Matters the Participation and Output of Partner LGU’s.</li>
              <li>The Effort to Understand and Appreciate Project Sustainability and Program Process Still Has A Lot to Improve and Strengthening.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">It binds the pigment of harmony:</h5>
          <p class="lead">
            <ul>
              <li>Harmony Through the Essence of Partnership, Coordination, Responsiveness Takes Effect into Attainment of Community Managed Implementation.</li>
              <li>Harmony on mutual effort, guidance, technical assistance to program partners earned smooth monitoring and supervision.</li>
              <li>Harmony to The Worthiness and Merit of The Project Beneficiaries/Implementor By Undertaking Sub-Project Construction.</li>
              <li>Harmony by Sharing Knowledge and Ideas to Program Partners to Achieve Better Planning and Execution.</li>
              <li>Harmony of Genuine Commitment to Project Stakeholder in Achieving Realistic Project Sustainability.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">But Behind the Binds of Pigment of Harmony Lies the Spots and Stains:</h5>
          <p class="lead">
            <ul>
              <li>Partnership, Coordination, Responsiveness Is the Opposite of One-Word Fear.</li>
              <li>The Effort, Guidance, Technical Assistance Has Something to Do with Failures and Lapses of The Staff and Partners.</li>
              <li>The Implementor (BSPMC) As Volunteers Cannot Expect Full Duties Along Project Construction Phase.</li>
              <li>The Assumption of Process That It Is an Infrastructure Program</li>
              <li>Most of The IGP Projects Still Needs Comprehensive and Detailed Operation Maintenance Strengthening.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">It is shape in a stroke of intensity:</h5>
          <p class="lead">
            <ul>
              <li>Intensity to push and speeding up construction activity by strategizing work breakdown items.</li>
              <li>Intensity of project immersion ensuring effective monitoring and supervision.</li>
              <li>Intensity of sub-project implementors accountability and responsibility to ensure completion in accordance to plan design and duration.</li>
              <li>Intensity of Tapping and Involving Project Partners from The Take-Off of Program Implementation.</li>
              <li>Intensity in Providing Intervention of Capacity Building Along Negative Condition of The Completed Projects.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">But a stroke of intensity lies the blots and taints:</h5>
          <p class="lead">
            <ul>
              <li>Apprehension of Field Facilitator to Implement Advance Procurement and Recurring Delay of Document Compliance.</li>
              <li>Issues of To Claims and Salary Rate of LGU Counterpart.</li>
              <li>Daily Attendance and Duties Along Construction Stage of Community Volunteers Affects Their Earnings and Income.</li>
              <li>Provision of LGU Counterpart Somehow Having Multi-Task Function Affects Participation in Construction Phase.</li>
              <li>Limited Fund Allocation and Thorough Assessment and Recommendation Of O&M Group/Association Hinder Project Sustainability.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">It was drawn freehandedly with tolerance:</h5>
          <p class="lead">
            <ul>
              <li>Tolerance to Internal Disagreement/Conflict Resolves Issues and Matter in Connection To CMI.</li>
              <li>Tolerance Security Threat, Peace and Order and Unfavorable Site Condition Did Not Deter Project Supervision and Monitoring.</li>
              <li>Tolerance to Sacrifice and Venture from The Proponent Community Resulting to Sub-Project Completion.</li>
              <li>Tolerance to The Partner Stakeholder’s Norm and Practice That Is Undesirable to Kc Process (Strict Timelines).</li>
              <li>Tolerance Level of Acceptance and Commitment to The End User in Sustaining Project Lifespan.</li>
            </ul>
          </p>

          <hr>
          <h5 class="text-info">But drawn in freehand with tolerance lies the sketchy outline:</h5>
          <p class="lead">
            <ul>
              <li>Disagreement/Conflict Caused Delays to Project Construction.</li>
              <li>Though Security Threat, Peace and Order and Unfavorable Site Condition Is Uncontrollable Still It Caused Delay to Project Construction.</li>
              <li>Community Sacrifice and Venture Were Not Captured to The BSPMC as a Whole.</li>
              <li>LGU and Communities’ norm and practice influences Kc process.</li>
              <li>Still the Mindset of Taking Care of Completed Project Persistently Taken for Granted.</li>
            </ul>
          </p>
        </div>
        <div class="col-sm-5">
          <img class="featurette-image img-fluid mx-auto" src="/images/for_about/drawing.png" style="width: 500px; height: 500px; object-fit: contain;" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-sm-7 order-sm-2">
          <h2 class="featurette-heading"> How the illustration of community managed implementation achieved? </h2>
          <p class="lead">
            <i class="fa fa-check"></i> 46 SP’s completed out of 46 for 293 areas as of December 31, 2018 in accordance to plan Design and Specifications.
          </p>
          <p class="lead">
            <i class="fa fa-check"></i> 94 out of 94 SP’s completed for ccl as of December 12, 2018 in accordance to plans and specifications.
          </p>
          <p class="lead">
            <i class="fa fa-check"></i> 19 out of 19 batch 1 Pamana IP-CDD SP’s were able to start as of December 2018.
          </p>
          <p class="lead">
            <i class="fa fa-check"></i> All Batch 2 Pamana IP-CDD Munis Were Able to Prepare Technical Engineering Documents.
          </p>
          <p class="lead">
            <i class="fa fa-check"></i> Capacity Building (Hands-On Demo with Provision of Maintenance Tool Kit) To All Barangay Electrician with SPSL To Ensuring Project Component Lifespan.
          </p>
          <p class="lead">
            <i class="fa fa-check"></i> 1 conclusive TCT with 29 approved subdivision plans.
          </p>
        </div>
        <div class="col-sm-5 order-sm-1">
          <img class="featurette-image img-fluid mx-auto" src="/images/for_about/notepad.png" style="width: 500px; height: 500px; object-fit: contain;" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->
    </div>
  </div>
</div>
</script>
@endsection