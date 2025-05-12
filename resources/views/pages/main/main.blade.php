@extends('layouts.main')

@section('title', 'FregaTrans Rental Mobil')

@section('content')
    @include('partials.main.carousel')
    <div class="container-fluid categories pb-5 pt-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Vehicle <span class="text-primary">Categories</span></h1>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores
                    commodi accusantium at cum harum, excepturi, quia tempora cupiditate! Adipisci facilis modi quisquam
                    quia distinctio,
                </p>
            </div>
            <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                @foreach ($cars as $car)
                    <div class="categories-item p-4">
                        <div class="categories-item-inner">
                            <div class="categories-img rounded-top">
                                <img src="{{ asset('storage/' . $car->image_primary) }}" class="img-fluid w-100 rounded-top"
                                    alt="">
                            </div>
                            <div class="categories-content rounded-bottom p-4">
                                <h4>{{ $car->model }}</h4>
                                <div class="categories-review mb-4">
                                    <div class="me-3">4.9 Review</div>
                                    <div class="d-flex justify-content-center text-secondary">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="row gy-2 gx-0 text-center mb-4">
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-users text-dark"></i> <span
                                            class="text-body ms-1">{{ $car->passenger_capacity }}</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i> <span
                                            class="text-body ms-1">{{ $car->fuel_type }}</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-gas-pump text-dark"></i> <span
                                            class="text-body ms-1">{{ $car->fuel_type }}</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-car text-dark"></i> <span
                                            class="text-body ms-1">{{ $car->year }}</span>
                                    </div>
                                    <div class="col-4 border-end border-white">
                                        <i class="fa fa-cogs text-dark"></i> <span
                                            class="text-body ms-1">{{ $car->transmission }}</span>
                                    </div>
                                    <div class="col-4">
                                        <i class="fa fa-road text-dark"></i> <span
                                            class="text-body ms-1">{{ $car->mileage }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('booking', ['id' => $car->id]) }}"
                                    class="btn btn-primary rounded-pill d-flex justify-content-center py-3">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('partials.main.features')
    @include('partials.main.process')
    @include('partials.main.fact-counter')
@endsection
