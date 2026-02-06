@extends('home.home_master')
@section('home')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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


                            <form class="register" action="{{ route('user.profile.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf


                                <div class="row justify-content-center mb-3">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center profile__image_content">
                                            <div class="profile_image" id='profile-thumb-show'>
                                                <img id="showImage"
                                                    src="{{ (!empty($profileData->photo)) ? url('upload/profile_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                                    class="rounded-circle avatar-xl" style="width: 150px; height:150px;">
                                            </div>
                                            <label for="image" class="profile-edit-icon"><i class="las la-pen"></i></label>
                                            <input id="image" type="file" class="form--control d-none" name="photo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label class="form--label">First Name</label>
                                        <input type="text" class="form--control" name="first_name"
                                            value="{{ $profileData->first_name }}">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="form--label">Last Name</label>
                                        <input type="text" class="form--control" name="last_name"
                                            value="{{ $profileData->last_name }}">
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label class="form--label"> User Name</label>
                                        <input type="text" class="form--control" name="name"
                                            value="{{ $profileData->name }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form--label">E-mail Address</label>
                                        <input class="form--control" type="email" name="email"
                                            value="{{ $profileData->email }}" readonly>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form--label">Mobile Number</label>
                                        <input class="form--control" name="phone" value="{{ $profileData->phone }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label class="form--label">Address</label>
                                        <input type="text" class="form--control" name="address"
                                            value="{{ $profileData->address }}">
                                    </div>

                                </div>

                                <button type="submit" class="btn btn--base w-100 mt-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })

    </script>

@endsection