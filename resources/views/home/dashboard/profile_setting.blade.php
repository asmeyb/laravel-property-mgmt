@extends('home.home_master')
@section('home')

<section class="breadcrumb bg-img"
    data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
    <div class="container ">
        <div class="breadcrumb__wrapper">
            <h3 class="breadcrumb__title">Profile Setting </h3>
        </div>
    </div>
</section>


    <div class="dashboard py-60 position-relative">
        <div class="container ">
            <div class="dashboard__wrapper">
 
        @include('home.body.dashboard_sidebar')

 <div class="dashboard-body">
                    <div class="flex-between breadcrumb-dashboard">
                        <div class="show-sidebar-btn mb-4">
                            <i class="fas fa-bars"></i>
                        </div>
                                            </div>
                        <div class="row dashboard-widget-wrapper justify-content-center">
        <div class="col-md-12">
            <form class="register" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="AgrQteztDPUt9ULMougURIKUlrFDk0lPkode5Rzl" autocomplete="off">
                <div class="row justify-content-center mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-center profile__image_content">
                            <div class="profile_image" id='profile-thumb-show'
                                style="background-image: url(//realvest/placeholder-image/350x300)">
                            </div>
                            <label for="profileImage" class="profile-edit-icon"><i class="las la-pen"></i></label>
                            <input id="profileImage" type="file" class="form--control d-none" name="avatar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">First Name</label>
                        <input type="text" class="form--control" name="firstname" value="Alik"
                            required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">Last Name</label>
                        <input type="text" class="form--control" name="lastname" value="Maga" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">E-mail Address</label>
                        <input class="form--control" value="[Email is protected for the demo]" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">Mobile Number</label>
                        <input class="form--control" value="55555555" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">Address</label>
                        <input type="text" class="form--control" name="address" value="Jakzkskks">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">State</label>
                        <input type="text" class="form--control" name="state" value="Jaksk">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label class="form--label">Zip Code</label>
                        <input type="text" class="form--control" name="zip" value="Az3000">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form--label">City</label>
                        <input type="text" class="form--control" name="city" value="Baku">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form--label">Country</label>
                        <input class="form--control" value="Azerbaijan" readonly>
                    </div>
                    
                </div>
                <button type="submit" class="btn btn--base w-100 mt-2">Submit</button>
            </form>
        </div>
    </div>
                </div>




            </div>
        </div>
    </div> 


@endsection