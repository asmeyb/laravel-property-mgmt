@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Withdraw Money</h3>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            @forelse ($profits as $propertyId => $propertyProfits)
                                    @php
                                        $property = $propertyProfits->first()->property;
                                        $totalProfit = $propertyProfits->sum('profit_amount');
                                        $withdrawn = $withdraws->get($propertyId, collect())->sum('withdraw_amount');
                                        $availableProfit = $totalProfit - $withdrawn;
                                    @endphp
                                    <div class="card mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <strong>Property: </strong> {{ $property->title }}
                                            <span class="badge bg-info">Available Profit: ${{ $availableProfit }}</span>
                                        </div>
                                    </div>



                                    <form action="{{ route('deposit.withdraw') }}" method="post" class="withdraw-form">
                                        @csrf

                                        <input type="hidden" name="property_id" value="{{ $propertyId }}">
                                        <input type="hidden" name="max-amount" value="{{ $availableProfit }}">

                                        <div class="gateway-card">
                                            <div class="row justify-content-center gy-sm-4 gy-3">
                                                <div class="col-lg-6">
                                                    <div class="payment-system-list is-scrollable gateway-option-list">
                                                        <label for="bank_transfer" class="payment-item  gateway-option">
                                                            <div class="payment-item__info">
                                                                <span class="payment-item__check"></span>
                                                                <span class="payment-item__name">Bank Transfer</span>
                                                            </div>
                                                            <div class="payment-item__thumb">
                                                                <img class="payment-item__thumb-img"
                                                                    src="{{ asset('frontend/assets/images/66544b3d1b3c41716800317.png') }}"
                                                                    alt="payment-thumb">
                                                            </div>
                                                            <input class="payment-item__radio gateway-input" id="bank_transfer"
                                                                type="radio" name="payment_type" value="bank_transfer"
                                                                data-min-amount="$1.00" data-max-amount="$10,000.00">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="payment-system-list p-3">
                                                        <div class="deposit-info">
                                                            <div class="deposit-info__title">
                                                                <p class="text mb-0">Amount</p>
                                                            </div>
                                                            <div class="deposit-info__input">
                                                                <div class="deposit-info__input-group input-group">
                                                                    <span class="deposit-info__input-group-text px-3">$</span>
                                                                    <input type="numer" class="form-control form--control amount"
                                                                        name="withdraw_amount"
                                                                        id="withdraw_amount_{{ $propertyId }}"
                                                                        value="{{ round($availableProfit) }}" autocomplete="off"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>


                                                        <div class="deposit-info">
                                                            <div class="deposit-info__title">
                                                                <p class="text has-icon">Processing Charge <span
                                                                        data-bs-toggle="tooltip"
                                                                        title="Processing charge for withdraw method"
                                                                        class="proccessing-fee-info">
                                                                        <i class="las la-info-circle"></i> </span>
                                                                </p>
                                                            </div>
                                                            <div class="deposit-info__input">
                                                                <div class="deposit-info__input-group input-group">
                                                                    <span class="deposit-info__input-group-text px-3">$</span>
                                                                    <input type="text" class="form-control form--control charge"
                                                                        name="charge" placeholder="00.00" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="deposit-info total-amount pt-3">
                                                            <div class="deposit-info__title">
                                                                <p class="text">Receivable</p>
                                                            </div>
                                                            <div class="deposit-info__input">
                                                                <div class="deposit-info__input-group input-group">
                                                                    <span class="deposit-info__input-group-text px-3">$</span>
                                                                    <input type="text" class="form-control form--control charge"
                                                                        name="receivable_amount"
                                                                        value="{{ round($availableProfit) }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <button type="submit" class="btn btn--base w-100"> Confirm Withdraw
                                                        </button>
                                                        <div class="info-text pt-3">
                                                            <p class="text">Safely withdraw your funds using our highly secure
                                                                process and various withdrawal method</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            @empty
                            <p class="text-muted text-center">No Profit available for withdrawal </p>
                        @endforelse



                    </div>
                </div>




            </div>
        </div>
    </div>


@endsection