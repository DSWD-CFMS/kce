@extends(Auth::check() ? 'layouts.dashboard' : 'layouts.app2')

@section('content')
<style type="text/css">
    .card:hover{
        -webkit-box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        -webkit-transition: box-shadow .5s; /* Safari prior 6.1 */
        transition: box-shadow: .5s;
        cursor: pointer;
    }
</style>
<div class="container-fluid" style="margin-top: 100px;" ng-init="show_albums()">
    <div class="row my-3">
        <div class="col-lg-10">
            <h1 class="font-weight-bold"> Gallery </h1>
            <p class="font-weight-light"> Take a look at some of the moments we shared </p>
        </div>
        <div class="col-lg-2" ng-if="ViewSpecificAlbum == true" ng-cloak>
            <button class="btn btn-primary btn-block" style="border-radius: 100px;" ng-click="back_to_albums()">Albums <i class="fa fa-th"></i></button>
        </div>

        <div class="col-lg-12" style="border-right:5px solid #eee;">
            <div class="row" ng-if="ViewSpecificAlbum == false">
                <div class="col-lg-3" ng-repeat="albums in gallery_data">
                    <div class="card border-light mb-3" ng-click="view_specific_album(albums)">
                      <div class="card-header"> <small>Sunday January 19, 2020</small> </div>
                      <div class="card-body">
                        <small class="font-weight-bold" ng-bind="albums.album"> </small>
                        <h5 class="card-title font-weight-light"> <span ng-bind="albums.gallery__images.length"></span> Photos </h5>
                        <p class="card-text text-truncate" ng-bind="albums.description">Technical Training on O&M Complex Design SPs for M/BLGU Officials and Operation & Maintenance Group</p>
                      </div>
                    </div>
                </div>
            </div>

            <div class="row" ng-if="ViewSpecificAlbum == true">
                <div class="col-lg-12 text-right px-5 py-5">
                    <h3 class="py-0 my-0" ng-bind="album_images.album"></h3>
                    <span ng-bind="album_images.created_at | date: 'fullDate'"></span>
                </div>

                <div class="col-lg-12 px-5">
                    <div class="lightBoxGallery">
                        @verbatim
                        <a ng-repeat="images in album_images.gallery__images track by $index" href="fetch_gallery_Image/{{images.id}}"  data-gallery="">
                            <img class="col-lg-3 px-0 py-0" style="height: 180px; width: 100%; object-fit: cover;" src="fetch_gallery_Image/{{images.id}}">
                        </a>
                        <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                        <div id="blueimp-gallery" class="blueimp-gallery">
                            <div class="slides"></div>
                            <h3 class="title"></h3>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                            <a class="play-pause"></a>
                            <ol class="indicator"></ol>
                        </div>
                        @endverbatim
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="row justify-content-center">

            </div>
        </div>
    </div>
</div>

@endsection
