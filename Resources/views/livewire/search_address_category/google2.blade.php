<div>
    <span novalidate="" name="address" class="ng-untouched ng-pristine ng-valid">
            

            {{-- 
            <input type="text" name="{{$name}}" wire:model='address'>
            --}}

            <div class="container-flud">
                <div class="row">
                    <div class="col-10">

                        <input type="text" data-google-address="{&quot;field&quot;: &quot;{{ $name }}&quot;}" class="form-control"
                        autocomplete="off" />
                        <div id="{{ $name }}_fields" style="display:none">
                        </div>
                    </div>
                    <div class="col-2">

                        <button type="submit" class="btn btn-primary" wire:click="viewCategories"> Cerca </button>
                    </div>
                    
                </div>
                
            </div>
            


            {{-- 
                <inputtype="text"name="civic"placeholder="N°"class="home-address-inputhome-civic-inputhidden-opacityng-untouchedng-pristineng-valid"> --}}
            
            {{-- 
            <button type="button" class="home-address-button home-geolocalize-button">
                <img src="{{ Theme::asset('pub_theme::img/svg/navigate.svg') }}">
            </button>
            --}}
        

    </span>

    @error('street_number')
        <div class="only-desktop home-error-popup home-address-messages">
            Per favore inserisci la via e il comune, poi scegli tra gli indirizzi suggeriti
        </div>
    @enderror
    
    @if($showCategories)
        @if(view()->exists('pub_theme::livewire.search_address_category.category'))
            @include('pub_theme::livewire.search_address_category.category')
        @else
            inserisci la blade che ti interessa
        @endif
    @endif


@push('styles')
    <style>
        .ap-input-icon.ap-icon-pin {
            right: 5px !important;
        }

        .ap-input-icon.ap-icon-clear {
            right: 10px !important;
        }

        .pac-container {
            z-index: 10000 !important;
        }

    </style>
@endpush

@push('scripts')
    <script>
        //Function that will be called by Google Places Library
        function initAutocomplete() {

            $('[data-google-address]').each(function() {
                var $this = $(this),
                    $addressConfig = $this.data('google-address'),
                    $field = $('[name="' + $addressConfig.field + '"]');
                var $extra_fields = $('#' + $addressConfig.field + '_fields');

                if ($field.val().length) {
                    //console.log($field.val());
                    var existingData = JSON.parse($field.val());
                    $this.val(existingData.value);
                }

                var $autocomplete = new google.maps.places.Autocomplete(
                    ($this[0]), {
                        types: ['geocode']
                    });

                $autocomplete.addListener('place_changed', function fillInAddress() {

                    var place = $autocomplete.getPlace();
                    console.log(place);
                    var value = $this.val();
                    var latlng = place.geometry.location; //place.geometry['location']??
                    var data = {
                        "value": value,
                        "latlng": latlng
                    };


                    for (var i = 0; i < place.address_components.length; i++) {
                        var addressType = place.address_components[i].types[0];
                        data[addressType] = place.address_components[i]['long_name'];
                        data[addressType + '_short'] = place.address_components[i]['short_name'];

                        $('<input>').attr({
                            'type': 'text',
                            'name': addressType,
                            'value': data[addressType]
                        }).appendTo($extra_fields);

                        $('<input>').attr({
                            'type': 'text',
                            'name': addressType + '_short',
                            'value': data[addressType + '_short']
                        }).appendTo($extra_fields);

                    }

                    $('<input>').attr({
                        'type': 'text',
                        'name': 'latitude',
                        'value': latlng.lat,
                    }).appendTo($extra_fields);
                    $('<input>').attr({
                        'type': 'text',
                        'name': 'longitude',
                        'value': latlng.lng,
                    }).appendTo($extra_fields);


                    //console.log('mio messaggio');
                    //console.log(place.address_components[0]['long_name']); //place.address_components[0]['long_name'] è il numero civico
                    
                    /*
                    for (var i = 0; i < place.address_components.length; i++) {
                        for (var j = 0; j < place.address_components[i].types.length; j++) {
                            if (place.address_components[i].types[j] == "street_number") {
                                console.log('street_number esiste');
                                @this.set('street_number',place.address_components[i].long_name);
                            }else{
                                console.log('street_number non esiste');
                                //@this.set('street_number','');
                            }
                        }
                    }
                    

                    @this.set('lat',latlng.lat());
                    @this.set('lng',latlng.lng());
                    @this.set('city',place.vicinity);
                    //@this.set('street_number',place.address_components[0]['long_name']);
                    */
                    @this.set('place',place);


                    $field.val(JSON.stringify(data));

                });

                $this.change(function() {
                    if (!$this.val().length) {
                        $field.val("");
                    }
                    $extra_fields.empty();
                });


            });

        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places&callback=initAutocomplete"
        async defer></script>
@endpush

</div>