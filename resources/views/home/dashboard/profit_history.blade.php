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
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($profits as $profit)
                                        <tr>
                                            <td>{{ optional($profit->property)->title ?? 'N\A' }}</td>
                                            <td>#INV{{ $profit->investment_id  }}</td>
                                            <td>${{ $profit->profit_amount  }}</td>
                                            <td>
                                                <div>
                                                    <span
                                                        class="small">{{ \Carbon\Carbon::parse($profit->paid_date)->diffForHumans() }}</span>
                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                No Profit History Found.
                                            </td>
                                        </tr>

                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!---- Capital Return --->

                    <div class="mt-4">
                        <h5 class="text-danger">Capital Return</h5>
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Capital Return </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        @if (isset($investment->capitalReturn) && $investment->capitalReturn)
                                        <div class="mt-2 text-success">
                                            Capital Back: ${{ $investment->capitalReturn->amount }}
                                            on {{
                                            \Carbon\Carbon::parse($investment->capitalReturn->paid_date)->format('d M,
                                            Y') }}
                                            (TRX:{{ $investment->capitalReturn->trx }} )
                                        </div>

                                        @else
                                        <div class="text-danger">
                                            <p>Capital is not return Yet</p>
                                        </div>
                                        @endif
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


@endsection