<!doctype html>
<!--
 @license
 Copyright 2025 Google LLC. All Rights Reserved.
 SPDX-License-Identifier: Apache-2.0
-->

<html>

<head>
    <title>Place Autocomplete element</title>

    <style>
        /**
 * @license
 * Copyright 2025 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */

        /* 
 * Always set the map height explicitly to define the size of the div element
 * that contains the map. 
 */
        #map {
            height: 100%;
        }

        /* 
 * Optional: Makes the sample page fill the window. 
 */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        p {
            font-family: Roboto, sans-serif;
            font-weight: bold;
        }
    </style>
    <script type="module">
        "use strict";
        /*
         * @license
         * Copyright 2025 Google LLC. All Rights Reserved.
         * SPDX-License-Identifier: Apache-2.0
         */

        async function initMap() {

            // Request needed libraries.
            await google.maps.importLibrary("places");
            // Create the input HTML element, and append it.
            //@ts-ignore
            const placeAutocomplete = new google.maps.places.PlaceAutocompleteElement();
            //@ts-ignore
            document.body.appendChild(placeAutocomplete);

            // Inject HTML UI.
            const selectedPlaceTitle = document.createElement('p');
            selectedPlaceTitle.textContent = '';
            document.body.appendChild(selectedPlaceTitle);
            const selectedPlaceInfo = document.createElement('pre');
            selectedPlaceInfo.textContent = '';
            document.body.appendChild(selectedPlaceInfo);

            // Add the gmp-placeselect listener, and display the results.
            //@ts-ignore
            placeAutocomplete.addEventListener('gmp-select', async ({
                placePrediction
            }) => {
                const place = placePrediction.toPlace();
                await place.fetchFields({
                    fields: ['displayName', 'formattedAddress', 'location']
                });
                selectedPlaceTitle.textContent = 'Selected Place:';
                selectedPlaceInfo.textContent = JSON.stringify(place.toJSON(), /* replacer */ null, /* space */ 2);
            });

        }
        initMap();
    </script>
</head>

<body>
    <p style="font-family: roboto, sans-serif">Search for a place here:</p>

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
            key: "AIzaSyBDH6OcgfnirI5a7pmMSUInirj3ZwoOlGU",
            v: "weekly"
        });
    </script>
</body>

</html>