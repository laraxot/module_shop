<div>
    <span novalidate="" name="address" class="ng-untouched ng-pristine ng-valid">
        <div id="address-group" class="home-address-group">
            <div class="pac-container pac-logo" style="display: none; width: 500px; position: absolute; left: 57px; top: 623px;"></div>
            
            <input type="hidden" name="{{$name}}" wire:model='address'>
            <input type="text" data-address="{&quot;field&quot;: &quot;{{$name}}&quot;}" 
                class="{{ $class }}" autocomplete="off" id="autocomplete" placeholder="{{ $placeholder }}"
                />

            {{-- 
                <inputtype="text"name="civic"placeholder="N°"class="home-address-inputhome-civic-inputhidden-opacityng-untouchedng-pristineng-valid"> --}}
            
            {{-- 
            <button type="button" class="home-address-button home-geolocalize-button">
                <img src="{{ Theme::asset('pub_theme::img/svg/navigate.svg') }}">
            </button>
            --}}
        
        </div>
        <div class="only-mobile" style="width: 100%;">

        <div style="clear: both;"></div>
        </div>
        <div class="only-mobile" style="width: 100%;">

            <div style="clear: both;"></div>
        </div>
        <button type="submit" class="home-address-button home-search-address-button" wire:click="viewCategories"> Cerca </button>
        <div style="clear: both;">
        
        
        </div>
    </span>
    
    @if($showCategories)
    <div class="activities-categories-home-container text-center fadeInUp animated">
        <div class="activities-categories-home">
            <button class="activities-categories-home-item">
                <img src="{{ Theme::asset('pub_theme::img/svg/food.svg') }}"><br>
                <p>Cibo</p>
            </button>
            <button class="activities-categories-home-item">
                <img src="{{ Theme::asset('pub_theme::img/svg/gifts.svg') }}"><br>
                <p>Regali</p>
            </button>
            <button class="activities-categories-home-item">
                <img src="{{ Theme::asset('pub_theme::img/svg/shopping.svg') }}"><br>
                <p>Shopping</p>
            </button>
            <button class="activities-categories-home-item">
                <img src="{{ Theme::asset('pub_theme::img/svg/beverage.svg') }}"><br>
                <p>Bevande &amp; Alcolici</p>
            </button>
            <button class="activities-categories-home-item">
                <img src="{{ Theme::asset('pub_theme::img/svg/markets.svg') }}"><br>
                <p>Supermercati</p>
            </button>
            <!---->
        </div>
    </div>
    @endif


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.11.0"></script>
    <script>
        $(document).ready(function(){
            window.AlgoliaPlaces = window.AlgoliaPlaces || {};

            $('[data-address]').each(function(){

                var $this      = $(this);
                var $addressConfig = $this.data('address');

               
                var $field = $('[name="'+$addressConfig.field+'"]');

                var $place = places({
                    //appId: '<YOUR_PLACES_APP_ID>',
                    //apiKey: '<YOUR_PLACES_API_KEY>',
                    container: $this[0],
                    style: true
                });
                function clearInput() {
                    if( !$this.val().length ){
                        $field.val('');
                    }
                }



                $place.on('change', function(e){
                    console.log(e.suggestion);
                    var result = JSON.parse(JSON.stringify(e.suggestion));

                    //$('input[name=lat]').val(result.latlng.lat);
                    //$('input[name=lng]').val(result.latlng.lng);
                    //$('input[name=city]').val(result.city);
                    @this.set('lat',result.latlng.lat);
                    @this.set('lng',result.latlng.lng);
                    @this.set('city',result.latlng.city);

                    delete(result.highlight); delete(result.hit); delete(result.hitIndex);
                    delete(result.rawAnswer); delete(result.query);

                    $field.val( JSON.stringify(result) );
                    //@this.set($addressConfig.field,JSON.stringify(result) );


                });

                $this.on('change blur', clearInput);
                $place.on('clear', clearInput);

                if( $field.val().length ){
                    var existingData = JSON.parse($field.val());
                    $this.val(existingData.value);
                }


                window.AlgoliaPlaces[ $addressConfig.field ] = $place;
            });
        });
    </script>
    @endpush

</div>