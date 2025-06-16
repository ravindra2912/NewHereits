@extends('front.layouts.main', ['seo' => [
'title' => 'Register your business | Hereits',
'description' => 'Register your business with Hereits and get more customers',
'keywords' => 'register, business, hereits',
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Register your business')

@push('style')
<style>
    .avtar_img {
        height: 160px;
        width: 160px;
        object-fit: contain;
        border-radius: 20px;
    }

    .avtar {
        border: 1px solid #ced4da;
        border-radius: 10px 10px 0px 0px;
        width: fit-content;
        padding: 10px;
        text-align: center;
    }

    .avtar-label {
        background: #0071cc;
        color: white;
        padding: 0px 3px 1px 5px;
        border-radius: 0px 0px 10px 10px;
        width: 100%;
        text-align: center;
    }

    .avtar_input {
        opacity: 0;
        height: 0px;
    }

    #place-autocomplete-card {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        margin: 2px;
        font-family: Roboto, sans-serif;
        font-size: large;
        font-weight: bold;
    }

    gmp-place-autocomplete {
        width: 300px;
    }

    #infowindow-content .title {
        font-weight: bold;
    }

    #map #infowindow-content {
        display: inline;
    }

    #map {
        height: 400px;
    }
</style>
@endpush

<section>

    <div class="container mt-3">
        <div class="bg-white shadow-md rounded p-4">
            <h4 class="mb-4">Fill your business Information</h4>
            <hr class="mx-n4 mb-4">

            @if(Auth::check())

            <form id="loginForm2" action="{{ route('register.business.store') }}" data-action="reload" class="formaction">
                @csrf
                <div class="row">

                    <div class="col-md-12 " style="justify-items: center;">
                        <div class="">
                            <div class="avtar">
                                <img src="{{ getImage('') }}" class="avtar_img" />

                            </div>
                            <label class="avtar-label" for="profile" title="Change Image">choose business image</label>
                        </div>
                        <input type="file" name="business_image" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
                    </div>


                    <div class="form-group col-lg-6">
                        <label for="business_name">Business name</label>
                        <input type="text" class="form-control" id="business_name" name="business_name" placeholder="First Name">
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="business_contact" name="business_contact" placeholder="Mobile Number">
                    </div>

                    <div class="form-group col-lg-6">
                        <div class="form-group">
                            <label>Business Category <span class="error">*</span></label>
                            <select class="form-control" name="business_category_id">
                                <option value="">Select Business Category</option>
                                @foreach ( $businessCat as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State <span class="error">*</span></label>
                            <select class="form-control" name="state_id" id="state_id">
                                <option value="">Select State</option>
                                @foreach ( getStates() as $state)
                                <option value="{{ $state->id }}" {{ $state->id == 12?'selected':'' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City <span class="error">*</span></label>
                            <select class="form-control" name="city_id" id="city_id">
                                <option value="">Select City</option>
                                @foreach ( getCities(12) as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Area <span class="error">*</span></label>
                            <select class="form-control" name="area_id" id="area_id">
                                <option value="">Select Area</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pincode <span class="error">*</span></label>
                            <input type="text" class="form-control" name="pincode" placeholder="Pincode" />
                        </div>
                    </div>

                    <div class="col-md-12 mt-2 mb-3">
                        <h5>Set Your business location</h5>
                        <div class="place-autocomplete-card" id="place-autocomplete-card">
                        </div>
                        <div id="map"></div>
                        <input type="hidden" name="latitude" id="lat" />
                        <input type="hidden" name="longitude" id="lng" />

                    </div>
                </div>
                <div class="col-12 text-right">
                <button class="btn btn-primary btn_action" type="submit">
                    <span id="buttonText">Submit</span>
                    <span id="loader" class="d-none">Submiting ...</span>
                </button>
                </div>
            </form>
            @else
            <div class="alert alert-info text-center mt-4" role="alert">
                <p class="mb-0">please login to your account to register your business</p>
                <p>if you don't have an account, please register</p>
                <button class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Login / Sign up</button>
            </div>
            @endif

        </div>
    </div>
</section>


@push('js')

<!-- prettier-ignore -->
<script>
    (g => {
        var h, a, k, p = "The Google Maps JavaScript API",
            c = "google",
            l = "importLibrary",
            q = "__ib__",
            m = document,
            b = window;
        b = b[c] || (b[c] = {});
        var d = b.maps || (b.maps = {}),
            r = new Set,
            e = new URLSearchParams,
            u = () => h || (h = new Promise(async (f, n) => {
                await (a = m.createElement("script"));
                e.set("libraries", [...r] + "");
                for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                e.set("callback", c + ".maps." + q);
                a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                d[q] = f;
                a.onerror = () => h = n(Error(p + " could not load."));
                a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                m.head.append(a)
            }));
        d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
    })
    ({
        key: "{{ env('GOOGLE_MAP_KEY') }}",
        v: "weekly"
    });
</script>

<script>
    let map;
    let marker;
    let infoWindow;
    let center = {
        lat: 21.170240,
        lng: 72.831060
    }; // New York City
    async function initMap() {
        // Request needed libraries.
        //@ts-ignore
        const [{
            Map
        }, {
            AdvancedMarkerElement
        }] = await Promise.all([
            google.maps.importLibrary("marker"),
            google.maps.importLibrary("places")
        ]);
        // Initialize the map.
        map = new google.maps.Map(document.getElementById('map'), {
            center,
            zoom: 5,
            mapId: '4504f8b37365c3d0',
            mapTypeControl: false,
        });
        //@ts-ignore
        const placeAutocomplete = new google.maps.places.PlaceAutocompleteElement();
        //@ts-ignore
        placeAutocomplete.id = 'place-autocomplete-input';
        placeAutocomplete.locationBias = center;
        const card = document.getElementById('place-autocomplete-card');
        //@ts-ignore
        card.appendChild(placeAutocomplete);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);
        // Create the marker and infowindow.
        marker = new google.maps.marker.AdvancedMarkerElement({
            map,
        });
        infoWindow = new google.maps.InfoWindow({});

        // Click to place marker
        map.addListener('click', (e) => {
            const clickedLocation = e.latLng;

            marker.position = clickedLocation;
            setLatLong(clickedLocation.lat(), clickedLocation.lng());
            // updateInfoWindow("Selected Location", clickedLocation);
        });

        // Add the gmp-placeselect listener, and display the results on the map.
        //@ts-ignore
        placeAutocomplete.addEventListener('gmp-select', async ({
            placePrediction
        }) => {

            const place = placePrediction.toPlace();

            await place.fetchFields({
                fields: ['displayName', 'formattedAddress', 'location']
            });
            setLatLong(place.location.lat(), place.location.lng())
            // If the place has a geometry, then present it on a map.
            if (place.viewport) {
                map.fitBounds(place.viewport);
            } else {
                map.setCenter(place.location);
                map.setZoom(17);
            }
            let content = '<div id="infowindow-content">' +
                '<span id="place-displayname" class="title">' + place.displayName + '</span><br />' +
                '<span id="place-address">' + place.formattedAddress + '</span>' +
                '</div>';
            // updateInfoWindow(content, place.location);
            marker.position = place.location;
        });
    }
    // Helper function to create an info window.
    function updateInfoWindow(content, center) {
        infoWindow.setContent(content);
        infoWindow.setPosition(center);
        infoWindow.open({
            map,
            anchor: marker,
            shouldFocus: false,
        });
    }

    function setLatLong(lat, lng) {
        $('#lat').val(lat);
        $('#lng').val(lng);
    }

    initMap();
</script>


<script>
    $('#state_id').on('change', function(event) {
        $.ajax({
            type: "POST",
            url: "{{ route('admin.getCities') }}",
            data: {
                state_id: $(this).val()
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#city_id').html('<option value="">Loading ...</option>');
            },
            success: function(states) {
                $('#city_id').html('<option value="">Select CitY</option>');
                $.each(states, function(index, item) {
                    $('#city_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                $('#city_id').html('<option value="">Select CitY</option>');
                alert("There was an error state chnage.");
            }
        });
    });

    $('#city_id').on('change', function(event) {
        $.ajax({
            type: "POST",
            url: "{{ route('admin.getCitieArea') }}",
            data: {
                city_id: $(this).val()
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#area_id').html('<option value="">Loading ...</option>');
            },
            success: function(states) {
                $('#area_id').html('<option value="">Select area</option>');
                $.each(states, function(index, item) {
                    $('#area_id').append('<option value="' + item.id + '">' + item.area_name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                $('#area_id').html('<option value="">Select area</option>');
                alert("There was an error state chnage.");
            }
        });
    });

    $('.avtar_input').on('change', function(event) {
        var input = event.target;
        var image = $('.avtar_img');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    })
</script>
@endpush

@endsection