@php
    $clientLogos = App\Models\ClientLogo::where('status', true)
                                      ->orderBy('order')
                                      ->get();
@endphp

<!-- Clients Section -->
<section class="clients-section">
    <div class="auto-container">
        <div class="sponsors-outer">
            <!--Sponsors Carousel-->
            <ul class="sponsors-carousel owl-carousel owl-theme">
                @foreach($clientLogos as $logo)
                <li class="slide-item">
                    <figure class="image">
                        <a href="{{ $logo->url ?? '#' }}" target="{{ $logo->url ? '_blank' : '_self' }}">
                            <img src="{{ asset('upload/client_logos/'.$logo->image) }}" 
                                 alt="{{ $logo->name }}">
                        </a>
                    </figure>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
<!-- End Clients Section -->
