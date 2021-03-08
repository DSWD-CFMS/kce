@extends('layouts.app')

@section('content')
<!-- <link href="{{ asset('css/welcome.css') }}" rel="stylesheet"> -->
<!-- Nav -->
<style type="text/css">
  /********************************/
/*            Overlay           */
/********************************/
.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 2;
    background-color: #080d15;
    opacity: .7;
}
</style>
<div id="inSlider" class="carousel slide" data-ride="carousel" >
  <ol class="carousel-indicators">
      <li data-target="#inSlider" data-slide-to="0" class="active"></li>
      <li data-target="#inSlider" data-slide-to="1"></li>
      <li data-target="#inSlider" data-slide-to="2"></li>
      <li data-target="#inSlider" data-slide-to="3"></li>
      <li data-target="#inSlider" data-slide-to="4"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
      <div class="carousel-item active">
        <div class="overlay"></div>
          <div class="container">
              <div class="carousel-caption blank">
                  <h1>KC ENGINEERING <br/> Gift Giving Event</h1>
                  <p>Tribal Village Brgy Sayon Sta. Josefa, Agusan del Sur</p>
                  <p><a class="btn btn-lg btn-primary" href="#" role="button">See More</a></p>
              </div>
          </div>
          <!-- Set background for slide in css -->
          <div class="header-back one"></div>
      </div>

      <div class="carousel-item">
        <div class="overlay"></div>
          <div class="container">
              <div class="carousel-caption blank">
                  <h1>KC ENGINEERING <br/> WRAP UP EVENT</h1>
                  <p>Almont Resort Lipata, Surigao del Norte</p>
                  <p><a class="btn btn-lg btn-primary" href="#" role="button">See More</a></p>
              </div>
          </div>
          <!-- Set background for slide in css -->
          <div class="header-back two"></div>
      </div>

      <div class="carousel-item">
        <div class="overlay"></div>
          <div class="container">
              <div class="carousel-caption blank">
                  <h1>KC ENGINEERING <br/> Gift Giving Event</h1>
                  <p>Brgy Maharlika Talacogon, Agusan del Sur</p>
                  <p><a class="btn btn-lg btn-primary" href="#" role="button">See More</a></p>
              </div>
          </div>
          <!-- Set background for slide in css -->
          <div class="header-back three"></div>
      </div>

      <div class="carousel-item">
        <div class="overlay"></div>
          <div class="container">
              <div class="carousel-caption blank">
                  <h1>KC ENGINEERING <br/> DENIM AND DIAMONDS <br> Christmas Party</h1>
                  <p>FSUU Morelos Campus, December 20, 2019</p>
                  <p><a class="btn btn-lg btn-primary" href="#" role="button">See More</a></p>
              </div>
          </div>
          <!-- Set background for slide in css -->
          <div class="header-back four"></div>
      </div>

      <div class="carousel-item">
        <div class="overlay"></div>
          <div class="container">
              <div class="carousel-caption blank">
                  <h1>KC ENGINEERING <br/> Program Implementation Review</h1>
                  <p>Almont Inland Resort, Butuan City, January 14-15, 2020</p>
                  <p><a class="btn btn-lg btn-primary" href="#" role="button">See More</a></p>
              </div>
          </div>
          <!-- Set background for slide in css -->
          <div class="header-back five"></div>
      </div>

  </div>
  <a class="carousel-control-prev" href="#inSlider" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#inSlider" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
  </a>
</div>
<!-- Carousel -->

<!-- <section id="features" class="container services">
  <div class="row">
    <div class="col-sm-6">
        <h1 class="font-weight-bold">Modalities</h1>
        <p class="font-weight-light"> These are on-going projects </p>
    </div>
    <div class="col-sm-3">
        <label><small class="font-weight-bold text-secondary"> Search </small></label>
        <input type="text" class="form-control" aria-describedby="search_employee" placeholder="Search..." ng-model="search_data_modality.$">
    </div>
    <div class="col-sm-3" style="align-self: center !important;">
        <button class="btn btn-light btn-block" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#filter_modal" style="border-radius:50px !important;"> <i class="fa fa-filter"></i> Filters </button>
    </div>
  </div>
</section> -->

<section id="team" class="gray-section team">
  <div class="container">
      <div class="row m-b-lg">
          <div class="col-lg-12 text-center">
              <div class="navy-line"></div>
              <h1>KALAHI-CIDSS ENGINEERING TEAM</h1>
              <p>RPMO staff and Field Staff</p>
          </div>
      </div>
      <div class="row">

          <div class="col-sm-4">
              <div class="team-member wow fadeInLeft">
                  <img style="object-fit: cover; height: 180px; width: 180px;" src="{{ asset('images/team/bernat.jpg') }}" class="img-fluid rounded-circle img-small" alt="">
                  <h4><span class="navy">Jovenal</span> L. Bernat</h4>
                  <p>REGIONAL COMMUNITY INFRASTRUCTURE SPECIALIST</p>
              </div>
          </div>
          <div class="col-sm-4 wow fadeInLeft">
              <div class="team-member">
                  <img style="object-fit: cover; height: 220px; width: 220px;" src="{{ asset('images/team/parajes.jpg') }}" class="img-fluid rounded-circle" alt="">
                  <h4><span class="navy">Jean Paul</span> S. Parajes</h4>
                  <p>DIVISION CHIEF PROMOTIVE SERVICES</p>
              </div>
          </div>
          <div class="col-sm-4 wow fadeInLeft">
              <div class="team-member">
                  <img style="object-fit: cover; height: 180px; width: 180px;" src="{{ asset('images/team/esphar.jpg') }}" class="img-fluid rounded-circle img-small" alt="">
                  <h4><span class="navy">Esphar</span> Lamella</h4>
                  <p>REGIONAL PROCUREMENT OFFICER</p>
              </div>
          </div>
      </div>
      <div class="row mt-5">
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/anna.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/marilou.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/beron.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/brother.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/arabijo.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/caingles.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/casido.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/chogen.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/cremson.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/dinopol.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/elbert.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/estrada.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/gapas.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/hadjisan.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/jayfred.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/juan.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/jphoi.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/julius.jpg') }}" class="img-fluid img-small" alt="">
          </div>

          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/lamanilao.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/maquiling.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/oclarit.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/potamio.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/ramiel.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/rocky.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/romeo.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/sergio.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/trazo.jpg') }}" class="img-fluid img-small" alt="">
          </div>
          <div class="col-sm-3 py-0 px-0 wow fadeIn">
            <img style="object-fit: cover; height:200px; width:100%;" src="{{ asset('images/team/wing.jpg') }}" class="img-fluid img-small" alt="">
          </div>
      </div>
  </div>
</section>

<section id="contact" class="gray-section contact">
  <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="navy-line"></div>
          <h1>Where are we located? <i class="fa fa-map"></i></h1>
        </div>
        <div class="col-lg-12">
            <iframe class="shadow1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.309045123509!2d125.53179811525476!3d8.943643292781402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3301c04fea75abc9%3A0xc04cf3f7a098d4e7!2sDepartment%20of%20Social%20Welfare%20and%20Development%20(DSWD)%20-%20Field%20Office%20Caraga!5e0!3m2!1sen!2sph!4v1571882136035!5m2!1sen!2sph" frameborder="0" style="border:0; width: 100%; height: 450px; border-radius: 16px;" allowfullscreen></iframe>
        </div>
      </div>
  </div>

  <div class="container">
      <div class="row m-b-lg">
          <div class="col-lg-12 text-center">
              <div class="navy-line"></div>
              <h1>Contact Us</h1>
              <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
          </div>
      </div>
      <div class="row m-b-lg justify-content-center">
          <div class="col-lg-3 ">
              <address>
                  <strong><span class="navy">Department of Social Welfare and Development (DSWD)</span></strong><br/>
                  8600 R. Palma St,<br/>
                  Butuan City, 8600 Agusan Del Norte<br/>
              </address>
          </div>
          <div class="col-lg-4">
              <p class="text-color">
                  The Philippines' Department of Social Welfare and Development is the executive department of the Philippine Government responsible for the protection of the social welfare of rights of Filipinos and to promote social development.
              </p>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12 text-center">
              <a href="https://www.gmail.com" class="btn btn-primary">Send us mail</a>
              <p class="m-t-sm">
                  Or follow us on social platform
              </p>
              <ul class="list-inline social-icon">
                  <li class="list-inline-item"><a href=""><i class="fa fa-twitter"></i></a>
                  </li>
                  <li class="list-inline-item"><a href="https://www.facebook.com/dswdcaraga/"><i class="fa fa-facebook"></i></a>
                  </li>
                  <li class="list-inline-item"><a href=""><i class="fa fa-linkedin"></i></a>
                  </li>
              </ul>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12 text-center m-t-lg m-b-lg">
              <p><strong>&copy; All Rights Reserved 2019 | DSWD Caraga & KC-ENGINEERING "COMMITTED TO EXCELLENCE"</strong></p>
          </div>
      </div>
  </div>
</section>

@endsection