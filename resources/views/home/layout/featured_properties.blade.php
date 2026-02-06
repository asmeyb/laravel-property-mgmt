@php
    $property = App\Models\Property::where('is_featured', 'yes')->orderBy('id', 'desc')->limit(3)->get();
@endphp

<section class="all-property py-120 bg-pattern">
    <div class="container ">
        <div class="section-heading style-left">
            <p class="section-heading__subtitle">Featured properties</p>
            <div class="section-heading__wrapper">
                <h2 class="section-heading__title">All Properties Spotlight</h2>
                <a class="section-heading__link" href="//properties">
                    <span>Explore</span>
                    <i class="las la-long-arrow-alt-right"></i>
                </a>
            </div>
        </div>
        <div class="all-property__cards">

            @foreach ($property as $item)
                <div class="card border-0 property-horizontal--card">
                    <a class="card-img card-img--lg" href="//property/traditional-machiya-townhouse">
                        <img src="{{ asset($item->image) }}" alt="property-image">
                    </a>
                    <div class="card-body py-md-4 px-md-4">
                        <div class="card-body-top mb-4">
                            <div class="card-wrapper flex-column">
                                <h4 class="card-title mb-1">
                                    <a href="">
                                        {{ $item->title }}
                                    </a>
                                </h4>
                                <ul class="card-meta card-meta--one">
                                    <li class="card-meta__item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="text">{{ $item->location->name }} </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body-middle mb-4">
                            <div class="card-progress mb-4">
                                <div class="card-progress__bar">
                                    <div class="card-progress__thumb" style="width: 100%;">
                                    </div>
                                </div>
                                <span class="card-progress__label fs-12">
                                    {{ $item->total_share }} Investors |
                                    ${{ $item->per_share_amount }}
                                    ({{ $item->down_payment }}%)
                                </span>
                            </div>
                            <ul class="card-meta card-meta--two">
                                <li class="card-meta__item">
                                    <div class="text">
                                        ${{ $item->profit_amount }}
                                    </div>
                                    <span class="subtext">Profit</span>
                                </li>
                                <li class="card-meta__item">
                                    <div class="text">
                                        <span>{{ $item->repeat_time }} </span>
                                    </div>
                                    <span class="subtext">Profit Schedule</span>
                                </li>
                                <li class="card-meta__item">
                                    <div class="text">
                                        {{ $item->capital_back }}
                                    </div>
                                    <span class="subtext">Capital Back</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body-bottom">
                            <a class="btn btn--sm btn--base" href=" " role="button"> Details </a>
                            <span class="card-price">
                                ${{ $item->per_share_amount }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach



        </div>
    </div>
</section>