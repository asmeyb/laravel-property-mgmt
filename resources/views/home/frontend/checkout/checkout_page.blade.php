@extends('home.home_master')
@section('home')

<div class="min-vh-100 d-flex flex-column">
    <main class="flex-grow-1 py-5">
        <div class="container">
            <h3>{{ $property->title }}</h3>

            <form action="{{ route('investment.store') }}" method="POST">
                @csrf

                <!--- Property Identification   --->
                <input type="hidden" name="property_id" value="{{ $property->id }}">
                <input type="hidden" name="slug" value="{{ $property->slug }}">

                <!--- Finacial Details   --->
                <input type="hidden" name="per_share_amount" value="{{ $property->per_share_amount }}">
                <input type="hidden" name="per_installment_amount" value="{{ $property->per_installment_amount }}">
                <input type="hidden" name="installment_late_fee" value="{{ $property->installment_late_fee }}">

                <!--- Investment Structure Details   --->
                <input type="hidden" name="total_installment" value="{{ $property->total_installment }}">
                <input type="hidden" name="investment_type" value="{{ $property->investment_type }}">
                <input type="hidden" name="time_id" value="{{ $property->time->id }}">

                <!--- Profit Details   --->
                <input type="hidden" name="profit_type" value="{{ $property->profit_type }}">

                @if ($property->profit_type === 'fixed')
                <input type="hidden" name="profit_amount" value="{{ $property->profit_amount }}">
                @else
                <input type="hidden" name="minimum_profit_amount" value="{{ $property->minimum_profit_amount }}">
                @endif

                <input type="hidden" name="profit_schedule" value="{{ $property->profit_schedule }}">
                <input type="hidden" name="repeat_time" value="{{ $property->repeat_time }}">

                <!--- Capital Return   --->
                <input type="hidden" name="capital_back" value="{{ $property->capital_back }}">
                <input type="hidden" name="profit_back" value="{{ $property->profit_back }}">

                <!--- Additional Fields   --->
                <input type="hidden" name="down_payment" value="{{ $property->down_payment }}">
                <input type="hidden" name="total_share" value="{{ $property->total_share }}">

                <input type="hidden" name="payment_type"
                    value="{{ strtolower($property->investment_type) == 'investment-by-installment' ? 'installment' : 'full' }}">


                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-lable fw-medium text-dark">Number of Shares</label>
                        <div class="input-group">
                            <input type="number" name="share_count" min="1" max="{{ $property->total_share }}" value="1"
                                class="form-control form-control-lg input-field" required>
                            <span class="input-group-text bg-transparent">Max: {{ $property->total_share -
                                $property->investments->sum('share_count') }}</span>
                        </div>
                        <div class="from-text mt-2"> Each Share represted as ownership</div>
                    </div>



                    <div class="col-md-6">
                        <label class="form-lable fw-medium text-dark">Price Per Share</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" value="{{ $property->per_share_amount }}" disabled
                                class="form-control form-control-lg bg-light">
                        </div>
                        <div class="from-text mt-2">Fixed price per investment unit</div>
                    </div>

                </div>

                <div class="mb-4">
                    <h3 class="h5 fw-semibold text-dark mb-3">Payment Methods </h3>
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="payment-method w-100 p-3 border rounded position-relative">
                                <input type="radio" name="payment_method" value="stripe" checked
                                    class="position-absolute top-0 end-0 m-2" style="z-index: 1;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                        style="width: 40x; height:40;">
                                        <i class="fab fa-stripe text-primary fs-5"></i>
                                    </div>
                                    <span class="fw-semibold">Credit Card</span>
                                </div>
                                <div class="mt-2 text-muted small">
                                    Pay instantly with Visa Mastercard
                                </div>
                            </label>
                        </div>


                        <div class="col-md-4">
                            <label class="payment-method w-100 p-3 border rounded position-relative">
                                <input type="radio" name="payment_method" value="cash"
                                    class="position-absolute top-0 end-0 m-2" style="z-index: 1;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                        style="width: 40x; height:40;">
                                        <i class="fas fa-money-bill-wave text-success fs-5"></i>
                                    </div>
                                    <span class="fw-semibold">Cash Payment</span>
                                </div>
                                <div class="mt-2 text-muted small">
                                    Pay in person at our office
                                </div>
                            </label>
                        </div>


                        <div class="col-md-4">
                            <label class="payment-method w-100 p-3 border rounded position-relative">
                                <input type="radio" name="payment_method" value="bank_transfer"
                                    class="position-absolute top-0 end-0 m-2" style="z-index: 1;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                        style="width: 40x; height:40;">
                                        <i class="fas fa-university text-info fs-5"></i>
                                    </div>
                                    <span class="fw-semibold">Bank Transfer</span>
                                </div>
                                <div class="mt-2 text-muted small">
                                    Transfer to our bank and Confirm
                                </div>
                            </label>
                        </div>


                    </div>
                </div>

                <div class="form-check mb-2" style="margin-top: 40px;">
                    <input class="form-check-input" type="checkbox" name="agreed_to_terms" id="terms" value="1"
                        required>
                    <label class="form-check-label text-dark" for="terms">
                        I agree to the
                        <a href="#" class="text-primary text-decoration-none">Terms of Service</a>,
                        <a href="#" class="text-primary text-decoration-none">Privacy Policy</a>, and confirm that I
                        have read the
                        <a href="#" class="text-primary text-decoration-none">Investment Prospectus</a>.
                    </label>
                </div>

                <button type="submit" class="w-100 btn btn-primary btn-lg py-3 fw-bold btn-hover-scale">
                    Complete Investment
                </button>

            </form>

        </div>

    </main>

</div>



@endsection