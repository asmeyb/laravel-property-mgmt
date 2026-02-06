@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Change Password </h3>
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
                    <div class="row justify-content-center dashboard-widget-wrapper">
                        <div class="col-md-12">
                            <form method="post">
                                <input type="hidden" name="_token" value="AgrQteztDPUt9ULMougURIKUlrFDk0lPkode5Rzl"
                                    autocomplete="off">
                                <div class="form-group">
                                    <label class="form--label">Current Password</label>
                                    <input type="password" class="form--control" name="current_password" required
                                        autocomplete="current-password">
                                </div>
                                <div class="form-group">
                                    <label class="form--label">Password</label>
                                    <input type="password" class="form--control " name="password" required
                                        autocomplete="current-password">
                                </div>
                                <div class="form-group">
                                    <label class="form--label">Confirm Password</label>
                                    <input type="password" class="form--control" name="password_confirmation" required
                                        autocomplete="current-password">
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