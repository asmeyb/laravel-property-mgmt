@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Deposit Money</h3>
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



                            <form action="{{ route('pay.installment.store') }}" method="post" class="deposit-form">
                                @csrf

                                <input type="hidden" name="installment_id" value="{{ $installment->id }}">
                                <input type="hidden" name="property_id"
                                    value="{{ $installment->investment->property->id }}">

                                <div class="gateway-card">
                                    <div class="row justify-content-center gy-sm-4 gy-3">
                                        <div class="col-lg-6">
                                            <div class="payment-system-list is-scrollable gateway-option-list">
                                                <div class="form-group mb-3">
                                                    <p>
                                                        <strong>Deposit for :</strong>
                                                        {{ $installment->investment->property->title }}
                                                        <span class="text-danger"><b>({{ $installmentType }})</b></span>
                                                    </p>

                                                </div>


                                                <label for="bank_transfer" class="payment-item  gateway-option">
                                                    <div class="payment-item__info">
                                                        <span class="payment-item__check"></span>
                                                        <span class="payment-item__name">Bank Transfer</span>
                                                    </div>
                                                    <div class="payment-item__thumb">
                                                        <img class="payment-item__thumb-img"
                                                            src="{{ asset('frontend/assets/images/663a39b8e64b91715091896.png') }}"
                                                            alt="payment-thumb">
                                                    </div>
                                                    <input class="payment-item__radio gateway-input" id="bank_transfer"
                                                        value="bank_transfer" name="payment_type" data-min-amount="$1.00"
                                                        type="radio" data-max-amount="$10,000.00">
                                                </label>



                                                <label for="hand_cash" class="payment-item  gateway-option">
                                                    <div class="payment-item__info">
                                                        <span class="payment-item__check"></span>
                                                        <span class="payment-item__name">Hand Cash</span>
                                                    </div>
                                                    <div class="payment-item__thumb">
                                                        <img class="payment-item__thumb-img"
                                                            src="{{ asset('frontend/assets/images/663a34d5d1dfc1715090645.png') }}"
                                                            alt="payment-thumb">
                                                    </div>
                                                    <input class="payment-item__radio gateway-input" id="hand_cash"
                                                        type="radio" name="payment_type" value="hand_cash"
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
                                                            <input type="text" class="form-control form--control amount"
                                                                name="amount" value="{{ $installment->amount }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="deposit-info">
                                                    <div class="deposit-info__title">
                                                        <p class="text has-icon"> Limit <span></span>
                                                        </p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text"><span class="gateway-limit">0.00</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="deposit-info">
                                                    <div class="deposit-info__title">
                                                        <p class="text has-icon">Processing Charge <span
                                                                data-bs-toggle="tooltip"
                                                                title="Processing charge for payment gateways"
                                                                class="proccessing-fee-info"><i
                                                                    class="las la-info-circle"></i> </span>
                                                        </p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text"><span class="processing-fee">0.00</span>
                                                            USD
                                                        </p>
                                                        <input type="hidden" name="charge" value="0">
                                                    </div>
                                                </div>

                                                <div class="deposit-info total-amount py-3">
                                                    <div class="deposit-info__title">
                                                        <p class="text">Total</p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text"><span
                                                                class="final-amount">{{ $installment->amount }}</span> USD
                                                        </p>
                                                        <input type="hidden" name="total_amount"
                                                            value="{{ $installment->amount }}">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn--base w-100"> Pay Installment </button>

                                                <div class="info-text pt-3">
                                                    <p class="text">Ensuring your funds grow safely through our secure
                                                        deposit process with world-class payment options.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>





            </div>
        </div>
    </div>


@endsection