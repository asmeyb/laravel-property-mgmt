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
                            <form action="//realvest/user/withdraw" method="post" class="withdraw-form">
                                <input type="hidden" name="_token" value="AgrQteztDPUt9ULMougURIKUlrFDk0lPkode5Rzl"
                                    autocomplete="off">
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
                                                        hidden
                                                        data-gateway='{"id":1,"form_id":20,"name":"Bank Transfer","image":"66544b3d1b3c41716800317.png","min_limit":"2.00000000","max_limit":"10000.00000000","fixed_charge":"1.00000000","rate":"1.00000000","percent_charge":"1.00","currency":"USD","description":"\u003Cdiv style=\u0022border-left: 3px solid #b5b0b0;\r\n    padding: 12px;\r\n    font-style: italic;\r\n    margin: 30px 0px;\r\n    background: #f9f9f9;\r\n    border-radius: 3px;\u0022\u003E\u003Cp style=\u0022margin-bottom: 10px; font-size: 17px;\u0022\u003EPlease complete the following information accurately to ensure timely processing of your payment. We are unable to assume responsibility for any delays or errors resulting from incomplete or inaccurate information.\u003C\/p\u003E\u003C\/div\u003E","status":1,"created_at":"2024-03-09T18:04:41.000000Z","updated_at":"2024-05-27T08:58:37.000000Z"}'
                                                        type="radio" name="method_code" value="1" checked
                                                        data-min-amount="$2.00" data-max-amount="$10,000.00">
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
                                                                name="amount" placeholder="00.00" value=""
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="deposit-info">
                                                    <div class="deposit-info__title">
                                                        <p class="text has-icon"> Limit</p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text"><span class="gateway-limit">0.00</span> </p>
                                                    </div>
                                                </div>
                                                <div class="deposit-info">
                                                    <div class="deposit-info__title">
                                                        <p class="text has-icon">Processing Charge <span
                                                                data-bs-toggle="tooltip"
                                                                title="Processing charge for withdraw method"
                                                                class="proccessing-fee-info"><i
                                                                    class="las la-info-circle"></i> </span>
                                                        </p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text">$<span class="processing-fee">0.00</span>
                                                            USD
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="deposit-info total-amount pt-3">
                                                    <div class="deposit-info__title">
                                                        <p class="text">Receivable</p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text">$<span class="final-amount">0.00</span>
                                                            USD</p>
                                                    </div>
                                                </div>

                                                <div class="deposit-info gateway-conversion d-none total-amount pt-2">
                                                    <div class="deposit-info__title">
                                                        <p class="text">Conversion </p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text"></p>
                                                    </div>
                                                </div>
                                                <div class="deposit-info conversion-currency d-none total-amount pt-2">
                                                    <div class="deposit-info__title">
                                                        <p class="text">
                                                            In <span class="gateway-currency"></span>
                                                        </p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text">
                                                            <span class="in-currency"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn--base w-100" disabled>
                                                    Confirm Withdraw </button>
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
                    </div>
                </div>




            </div>
        </div>
    </div>


@endsection