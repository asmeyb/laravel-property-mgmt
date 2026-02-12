@php
    $property = App\Models\Property::orderBy('id','desc')->limit(3)->get();
@endphp

<section class="latest-property py-120 bg-pattern bg-pattern-bottom-right">
    <div class="container ">
        <div class="section-heading style-left">
            <p class="section-heading__subtitle">Latest properties</p>
            <div class="section-heading__wrapper">
                <h2 class="section-heading__title">Explore Latest Properties</h2>
                <a class="section-heading__link" href="//properties">
                    <span>Explore</span>
                    <i class="las la-long-arrow-alt-right"></i>
                </a>
            </div>
        </div>
        <div class="row gy-4 g-sm-3 g-md-4 justify-content-center">
            
     @foreach ($property as $item) 
    <div class="col-sm-6 col-lg-4">
    <article class="card property--card border-0">
        <a class="card-img-top " href="{{ route('property.details',$item->slug) }}">
            <img src="{{ asset($item->image) }}"
                alt="property-image">
        </a>
        <div class="card-body px-2 py-3 p-md-3 p-xl-4">
            <div class="card-body-top">
                <h5 class="card-title mb-2">
                    <a href="{{ route('property.details',$item->slug) }}">{{ $item->title }} </a>
                </h5>
                <ul class="card-meta card-meta--one">
                    <li class="card-meta__item card-meta__item__location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="text">{{ $item->location->name }} </span>
                    </li>
                </ul>
            </div>
            <div class="card-body-middle">
                <div class="card-progress mb-4">
                    <div class="card-progress__bar">
                        <div class="card-progress__thumb" style="width: 100%;"></div>
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
                            Repeat  {{ $item->repeat_time }} (Monthly)
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
            <div class="card-body-bottom mb-4">
                <a class="btn btn--sm btn--base" href="{{ route('property.details',$item->slug) }}"
                    role="button">Details</a>
                <span class="card-price">${{ $item->per_share_amount }}</span>
            </div>
        </div>
    </article>
</div>
 @endforeach 

     

        </div>
    </div>
</section>