<div class="item">
    <div class="box_grid">
        <figure>
            <a href="tour-details.php">
                <img src="{{ asset('storage/tour/medium/'.$tour->thumbnail->name) }}" class="img-fluid" alt="" width="800" height="533">
                <div class="read_more">
                    <span>Read more</span>
                </div>
            </a>
            <small>
                @if($tour->category)

                    @if(Config::get('app.locale') == 'en')
                    {{ $tour->category->name_en }}
                    @else
                    {{ $tour->category->name_fr }}
                    @endif

                @endif
            </small>
        </figure>
        <div class="wrapper">
            <h3>
                <a href="tour-details.php">
                    @if(Config::get('app.locale') == 'en')
                    {{ substr(strip_tags($tour->description_en),0,40).'...'; }}
                    @else 
                    {{ $tour->title_fr }}
                    @endif
                </a>
            </h3>
            <p>
                @if(Config::get('app.locale') == 'en')
                {{ substr(strip_tags($tour->description_en),0,100).'...'; }}
                @else 
                {{ substr(strip_tags($tour->description_fr),0,100).'...'; }}
                @endif
            </p>
            <span class="price">From <strong>@if($tour->lowest_price_package) {{ $tour->lowest_price_package_currency }} {{ currency_sympol() }} @endif</strong> /{{ $tour->lowest_price_package_room }}</span>
        </div>
        <ul class="d-flex">
            <li><i class="icon_clock_alt mx-2"></i>{{$tour->duration_text_in_en}}</li>
        </ul>
    </div>
</div>