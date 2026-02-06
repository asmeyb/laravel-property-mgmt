@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Dashboard</h3>
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
                    <div class="notice"></div>


                    <div class="row gy-4 dashboard-widget-wrapper mb-4 justify-content-center">
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-donate"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Balance</span>
                                    <h6 class="dashboard-widget__number">
                                        $999.99
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Total Deposit</span>
                                    <h6 class="dashboard-widget__number">
                                        $10,000.00
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="far fa-credit-card"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Total Withdraw</span>
                                    <h6 class="dashboard-widget__number">
                                        $0.00
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Total Investment</span>
                                    <h6 class="dashboard-widget__number">
                                        $20,000.00
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Total Profit</span>
                                    <h6 class="dashboard-widget__number">
                                        $999.99
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-city"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Total Invested Property</span>
                                    <h6 class="dashboard-widget__number">
                                        3
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-bezier-curve"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">My Referrals</span>
                                    <h6 class="dashboard-widget__number">
                                        0
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Referral Commission</span>
                                    <h6 class="dashboard-widget__number">
                                        $0.00
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6 ">
                            <div class="dashboard-widget flex-align">
                                <div class="dashboard-widget__icon flex-center">
                                    <i class="fa fa-ticket-alt"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <span class="dashboard-widget__text">Total Ticket</span>
                                    <h6 class="dashboard-widget__number">
                                        0
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>






@endsection