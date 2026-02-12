@extends('home.home_master')
@section('home')

    <section class="breadcrumb bg-img"
        data-background-image="{{ asset('frontend/assets/images/65c469d3e22771707370963.png') }}">
        <div class="container ">
            <div class="breadcrumb__wrapper">
                <h3 class="breadcrumb__title">Property Details</h3>
            </div>
        </div>
    </section>
    <section class="property-details py-60 bg-pattern">
        <div class="container ">
            <div class="row gy-4 gy-lg-0 row--one">
                <div class="col-lg-7 col-xxl-8">
                    <div class="mb-4">
                        <h4 class="property-details__title mb-0">{{ $property->title }}</h4>
                        <ul class="property-details-metan">
                            <li class="property-details-meta__item">
                                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="text">{{ $property->location->name }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="property-details__block mb-4">
                        <div class="property-details__slider">

                            <img class="property-details__slider-img" src="{{ asset($property->image) }}"
                                alt="property-image">

                            @foreach ($property->galleryImages as $img)
                                <img class="property-details__slider-img" src="{{ asset($img->image) }}" alt="property-image">
                            @endforeach

                        </div>

                        <div class="property-details__thumb">

                            <img class="property-details__slider-img" src="{{ asset($property->image) }}"
                                alt="property-image">
                            @foreach ($property->galleryImages as $img)
                                <img class="property-details__slider-img" src="{{ asset($img->image) }}" alt="property-image">
                            @endforeach

                        </div>
                    </div>
                    <div class="property-details__block mb-4">
                        <div class="mb-3">
                            <h5 class="title">Property Description</h5>
                            <div class="property-details__desc">
                                {!! $property->details !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="title">Location</h5>
                            <iframe class="property-details__map" src="{{ $property->location_map }}" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                    <div class="property-details__block">
                        <h5 class="title">Share now</h5>
                        <div class="mb-3">
                            @php
                                $propertUrl = urlencode(route('property.details', $property->slug));
                                $propertyTitle = urlencode($property->title);
                            @endphp
                            <ul class="social-list social-list--soft">
                                <li class="social-list__item">
                                    <a class="social-list__link"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{$propertUrl}} "
                                        target="_blank">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                </li>
                                <li class="social-list__item">
                                    <a class="social-list__link"
                                        href="https://twitter.com/intent/tweet?text=Luxury Condominiums&amp;url={{$propertUrl}}"
                                        target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="social-list__item">
                                    <a class="social-list__link"
                                        href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{$propertUrl}};title={{$propertyTitle}}"
                                        target="_blank">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                </li>
                                <li class="social-list__item">
                                    <a class="social-list__link"
                                        href="https://www.instagram.com/sharer.php?u={{$propertUrl}}" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="input-group input-group--copy">
                            <input class="form--control" type="text" value="{{ route('property.details', $property->slug) }}"
                                readonly>
                            <button class="btn btn-soft--base" type="button"
                                onclick="navigator.clipboard.writeText({{ route('property.details', $property->slug) }})">
                                <i class="las la-copy"></i>
                                <span>Copy</span>
                            </button>
                        </div>
                    </div>
                </div>




                <div class="col-lg-5 col-xxl-4">
                    <div class="property-details__price mb-4">
                        <h3 class="mb-0">
                            ${{ $property->per_share_amount }}
                        </h3>
                        <span class="text">Per Share Amount</span>
                    </div>

                    <div class="property-details__buttons mb-md-4 mb-0">
                        <a href="login" type="button" class="btn btn--lg btn--base">
                            Invest Now </a>
                        <button type="button" class="btn btn--lg btn-outline--base d-lg-none" data-toggle="sidebar"
                            data-target="#property-details-sidebar">
                            <i class="fas fa-info-circle"></i>
                            <span>Details</span>
                        </button>
                    </div>

                    <div id="property-details-sidebar" class="property-details-sidebar">
                        <button type="button" class="close-btn">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="property-details-sidebar__block mb-4">
                            <div class="block-heading">
                                <p class="block-heading__subtitle">Available:
                                    0 Share </p>
                            </div>
                            <div class="card-progress mt-2">
                                <div class="card-progress__bar">
                                    <div class="card-progress__thumb" style="width: 100%;">
                                    </div>
                                </div>
                                <span class="card-progress__label fs-12">
                                    2 Investors |
                                    $45,000.00
                                    (100%)
                                </span>
                            </div>
                            <ul class="property-details-amount-info">
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/invest_type.png') }}" alt="img">
                                        Investment Type </span>
                                    <span class="value fw-bold"> {{ $property->investment_type }} </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/profit.png') }}" alt="img">
                                        Profit </span>
                                    @if ($property->profit_type === 'fixed')
                                        <span class="value fw-bold">
                                            ${{ $property->profit_amount }} Fixed
                                        </span>
                                    @else
                                        <span class="value fw-bold">
                                            ${{ $property->minimum_profit_amount }} %
                                        </span>
                                    @endif
                                </li>

                                @php
                                    $downPaymentAmount = ($property->per_share_amount * $property->down_payment) / 100;
                                    $initialAmount = $property->per_share_amount - $downPaymentAmount;
                                @endphp
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/down_payment.png') }}" alt="img">
                                        Down Payment </span> <span class="value fw-bold">{{ $property->down_payment }}%
                                        (${{$downPaymentAmount}})</span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/init_amount.png') }}" alt="img">
                                        Initial Invest Amount </span>
                                    <span class="value fw-bold">
                                        ${{ $initialAmount }}
                                    </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/total_installment.png') }}"
                                            alt="img">
                                        Total Installments </span>
                                    <span class="value fw-bold">{{ $property->total_installment }}</span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/per_installment.png') }}"
                                            alt="img">
                                        Per Installment Amount </span>
                                    <span class="value fw-bold">
                                        ${{ $property->per_installment_amount }}
                                    </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/installment_schedule.png') }}"
                                            alt="img">
                                        Installment Schedule </span>
                                    <span class="value fw-bold">
                                        {{ $property->time->time_name }}
                                    </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/late_fee.png') }}" alt="img">
                                        Installment Late Fee </span>
                                    <span class="value fw-bold">
                                        ${{ $property->installment_late_fee }}
                                    </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/profit_schedule.png') }}"
                                            alt="img">
                                        Profit Schedule </span>
                                    <span class="value fw-bold">
                                        {{ $property->profit_schedule }}
                                    </span>
                                </li>

                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/profit_repeat.png') }}" alt="img">
                                        Profit Repeat </span>
                                    <span class="value fw-bold">
                                        {{ $property->repeat_time }} Times </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/capital_back.png') }}" alt="img">
                                        Capital Back </span>
                                    <span class="value fw-bold">
                                        {{ $property->capital_back }}
                                    </span>
                                </li>
                                <li class="property-details-amount-info__item">
                                    <span class="label">
                                        <img src="{{ asset('frontend/assets/images/icons/profit_back.png') }}" alt="img">
                                        Profit Return </span>
                                    <span class="value fw-bold">After
                                        {{ rtrim(rtrim(number_format($property->profit_back, 10), '0'), '.') }} Days </span>
                                </li>
                            </ul>
                        </div>

                        <div class="property-details-sidebar__block">
                            <div class="block-heading">
                                <h6 class="block-heading__title">Latest Properties</h6>
                            </div>
                            <div class="property-details__cards">

                                @foreach ($latestProperties as $item)

                                    <div class="property-details-card">
                                        <div class="property-details-card__thumb">
                                            <a href="{{ route('property.details', $item->slug) }}">
                                                <img src="{{ asset($item->image) }}" alt="Property-image">
                                            </a>
                                        </div>
                                        <div class="property-details-card__content">
                                            <h6 class="title">
                                                <a href="{{ route('property.details', $item->slug) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </h6>
                                            <div class="location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span> {{ $item->location->name }}</span>
                                            </div>
                                            <span class="price">
                                                ${{ $item->per_share_amount }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection