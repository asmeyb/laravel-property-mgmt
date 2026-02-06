@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Profit History</h3>
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
                                <input type="text" name="search" class="form--control" value="" placeholder="Search ...">
                                <button class="btn--base btn" type="submit">
                                    <span class="icon"><i class="la la-search"></i></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="table-responsive table--responsive--xl">
                                <table class="table custom--table">
                                    <thead>
                                        <tr>
                                            <th>Property</th>
                                            <th>Investment Id</th>
                                            <th>TRX</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Luxury Penthouse</td>
                                            <td>6UUA19ARD4</td>
                                            <td>HMYHQAE2COVR</td>
                                            <td>$999.99</td>
                                            <td>
                                                <div>
                                                    2024-04-20 12:00 AM<br>
                                                    <span class="small">1 year ago</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>


@endsection