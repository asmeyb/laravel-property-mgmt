@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">My Investment</h3>
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
                    <div class="flex-end mb-4 breadcrumb-dashboard">
                        <form>
                            <div class="input-group">
                                <input type="text" name="search" class="form--control" value="" placeholder="Property name">
                                <button class="btn--base btn" type="submit">
                                    <span class="icon"><i class="la la-search"></i></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="row dashboard-widget-wrapper justify-content-center">
                        <div class="col-md-12">
                            <div class="table-responsive table--responsive--xl">
                                <table class="table custom--table">
                                    <thead>
                                        <tr>
                                            <th>Property</th>
                                            <th>Invested Amount</th>
                                            <th>Due Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="//realvest/property/stylish-apartment">
                                                    <strong>Stylish Apartment</strong>
                                                </a>
                                            </td>
                                            <td><strong>$20,000.00</strong>
                                            </td>
                                            <td><strong>$14,000.00</strong></td>
                                            <td><span class="badge badge--primary">Running</span></td>
                                            <td>


                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade custom--modal" id="detailModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Investment Details</h5>
                                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                                        <i class="las fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-form__header">
                                        <ul class="list-group userData mb-2 list-group-flush"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>


@endsection