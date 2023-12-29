@extends('layouts.app', ['page_title' => 'Index'])

@section('css')
    @include('partials.map-css')

    <style>
        #map {
            height: 700px;
        }
    </style>
@endsection
@section('content')
    @if (Session::has('failed'))
        <div class="alert {{ Session::get('alert-class', 'alert-secondary') }}" role="alert">
            {{ Session::get('failed') }}

            <button type="button" class="close border-0 bg-transparent" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif


    <section class="content-header">
        <div class="container-  ">
            <div class="row  " style="flex-wrap:nowrap">
                <div class="col-sm-6">
                    <h3>Link box</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">index</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid bg-white pt-2">



        <div class="card p-0 mb-3">
            <div class="card-body row form-input">

                <div class="col-md-2">
                    <label for="search_zone">Zone</label>
                    <select name="search_zone" id="search_zone" class="form-control" onchange="onChangeZone(this.value)">

                        @if (Auth::user()->zone == '')
                            <option value="" hidden>select zone</option>
                            <option value="W1">W1</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="B4">B4</option>
                        @else
                            <option value="{{ Auth::user()->zone }}" hidden>{{ Auth::user()->zone }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="search_ba">BA</label>
                    <select name="search_ba" id="search_ba" class="form-control" onchange="callLayers(this.value)">

                        <option value="{{ Auth::user()->ba }}" hidden>
                            {{ Auth::user()->ba != '' ? Auth::user()->ba : 'Select BA' }}</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="from_date">Fom</label>
                    <input type="date" class="form-control" id="from_date" onchange="filterByDate(this)" />
                </div>

                <div class="col-md-2">
                    <label for="to_date">To</label>
                    <input type="date" class="form-control" id="to_date" onchange="filterByDate(this)" />
                </div>


                <div class="col-md-2">
                    <br />
                    <input type="button" class="btn btn-secondary mt-2" id="reset" value="Reset"
                        onclick="resetMapFilters()" />
                </div>



            </div>
        </div>

        <div class="p-3 form-input  ">
            <label for="select_layer">Select Layer : </label>
            <span class="text-danger" id="er-select-layer"></span>

            <div class="d-sm-flex">


                <div class="mx-4">
                    <input type="radio" name="select_layer" id="lb_with_defects" class="with_defects"
                        value="lb_with_defects" onchange="selectLayer(this.value)">
                    <label for="lb_with_defects">Surveyed with defects</label>
                </div>

                <div class="mx-4">
                    <input type="radio" name="select_layer" id="lb_without_defects" class="without_defects"
                        value="lb_without_defects" onchange="selectLayer(this.value)">
                    <label for="lb_without_defects">Surveyed without defects</label>
                </div>

                {{-- @if (Auth::user()->ba != '') --}}
                    <div class=" mx-4">
                        <input type="radio" name="select_layer" id="select_layer_unsurveyed" value="lb_unsurveyed"
                            onchange="selectLayer(this.value)" class="unsurveyed">
                        <label for="select_layer_unsurveyed">Unsurveyed </label>
                    </div>

                    <div class=" mx-4">
                        <input type="radio" name="select_layer" id="select_layer_pending" value="lb_pending"
                            onchange="selectLayer(this.value)" class="pending">
                        <label for="select_layer_pending">Pending </label>
                    </div>


                    <div class=" mx-4">
                        <input type="radio" name="select_layer" id="lb_reject" value="lb_reject"
                            onchange="selectLayer(this.value)" class="reject">
                        <label for="lb_reject">Reject </label>
                    </div>
                {{-- @endif --}}



                <div class=" mx-4">
                    <input type="radio" name="select_layer" id="select_layer_pano" value="pano"
                        onchange="selectLayer(this.value)">
                    <label for="select_layer_pano">Pano</label>
                </div>


                <div class="mx-4">
                    <div id="the-basics">
                        <input class="typeahead" type="text" placeholder="search id" class="form-control">
                    </div>
                </div>
            </div>

        </div>

        <!--  START MAP CARD DIV -->
        <div class="row m-2">

            <!-- START MAP SIDEBAR DIV -->
            {{-- <div class="col-2 p-0">
            <div class="card p-0 m-0"
                style="border: 1px solid rgb(177, 175, 175) !important; border-radius: 0px !important">
                <div class="card-header"><strong> NAVIGATION</strong></div>
                <div class="card-body">
                    <!-- MAP SIDEBAR LAYERS SELECTOR -->
                    <div class="side-bar" style="height: 569px !important; overflow-y: scroll;">


                        <!-- START MAP SIDEBAR DETAILS -->




                        <details class="mb-3" open>
                            <summary><strong>Link Box</strong> </summary>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Pemeriksaan visual</td>
                                </tr>
                                <tr>
                                    <td>Pembersihan iklan haram/banner</td>
                                </tr>
                                <tr><td>
                                    Pembersihan semak samun / creepers/sampah/ rumput</td></tr>
                                <tr>
                                    <td>Report</td>
                                </tr>
                            </table>

                        </details>




                        <!-- END MAP SIDEBAR DETAILS -->
                    </div>
                </div>
            </div>
        </div> --}}
            <!-- END MAP SIDEBAR DIV -->

            <!-- START MAP  DIV -->
            <div class="col-md-8 p-0 ">
                <div class="card p-0 m-0"
                    style="border: 1px solid rgb(177, 175, 175) !important; border-radius: 0px !important;">
                    <div class="card-header text-center"><strong> MAP</strong></div>
                    <div class="card-body p-0">
                        <div id="map">

                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="card p-0 m-0"
                    style="border: 1px solid rgb(177, 175, 175) !important; border-radius: 0px !important;">

                    <div class="card-header text-center"><strong>Detail</strong></div>

                    <div class="card-body p-0" style="height: 700px ;overflow: hidden;" id='set-iframe'>

                    </div>
                </div>
            </div>
            <!-- END MAP  DIV -->
            <div id="wg" class="windowGroup">

            </div>

            <div id="wg1" class="windowGroup">

            </div>

        </div><!--  END MAP CARD DIV -->
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Site Data Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <table class="table table-bordered">
                        <tbody id="my_data"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('partials.map-js')


    <script>
        var substringMatcher = function(strs) {

            return function findMatches(q, cb) {

                var matches;

                matches = [];
                $.ajax({
                    url: '/{{ app()->getLocale() }}/search/find-link-box/' + q,
                    dataType: 'JSON',
                    //data: data,
                    method: 'GET',
                    async: false,
                    success: function callback(data) {
                        $.each(data, function(i, str) {

                            matches.push(str.id);

                        });
                    }
                })

                cb(matches);
            };
        };


        var marker = '';
        $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'states',
            source: substringMatcher()
        });

        $('.typeahead').on('typeahead:select', function(event, suggestion) {
            var name = encodeURIComponent(suggestion);

            if (marker != '') {
                map.removeLayer(marker)
            }
            $.ajax({
                url: '/{{ app()->getLocale() }}/search/find-link-box-cordinated/' + encodeURIComponent(
                    name),
                dataType: 'JSON',
                //data: data,
                method: 'GET',
                async: false,
                success: function callback(data) {
                    console.log(data);
                    map.flyTo([parseFloat(data.y), parseFloat(data.x)], 16, {
                        duration: 1.5, // Animation duration in seconds
                        easeLinearity: 0.25,
                    });

                    marker = new L.Marker([data.y, data.x]);
                    map.addLayer(marker);
                }
            })

        });
    </script>


    <script>
        // for add and remove layers
        function addRemoveBundary(param, paramY, paramX) {




            if (work_package) {
                map.removeLayer(work_package);
            }

            work_package = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:tbl_workpackage',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })
            map.addLayer(work_package)
            // work_package.bringToFront()



            if (boundary !== '') {
                map.removeLayer(boundary)
            }



            boundary = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ba',
                format: 'image/png',
                cql_filter: "station ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })
            map.addLayer(boundary)
            boundary.bringToFront()


            if (pano_layer !== '') {
                map.removeLayer(pano_layer)
            }
            pano_layer = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:pano_apks',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            });
            // map.addLayer(pano_layer);
            // map.addLayer(pano_layer)




            map.flyTo([parseFloat(paramY), parseFloat(paramX)], zoom, {
                duration: 1.5, // Animation duration in seconds
                easeLinearity: 0.25,
            });

            updateLayers(param);

        }


        function updateLayers(param) {

            var q_cql = "ba ILIKE '%" + param + "%' "
            if (from_date != '') {
                q_cql = q_cql + "AND visit_date >=" + from_date;
            }
            if (to_date != '') {
                q_cql = q_cql + "AND visit_date <=" + to_date;
            }


            if (lb_without_defects != '') {
                map.removeLayer(lb_without_defects)
            }
            lb_without_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:lb_without_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(lb_without_defects)
            lb_without_defects.bringToFront()


            // link box with defects ----

            if (lb_with_defects != '') {
                map.removeLayer(lb_with_defects)
            }

            lb_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:lb_with_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })


            map.addLayer(lb_with_defects)
            lb_with_defects.bringToFront()



            // if user is not admin
            // if (ba !== '') {



                if (lb_pending != '') {
                    map.removeLayer(lb_pending)
                }

                lb_pending = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                    layers: 'cite:sub_reject',
                    format: 'image/png',
                    cql_filter: q_cql,
                    maxZoom: 21,
                    transparent: true
                }, {
                    buffer: 10
                })


                map.addLayer(lb_pending)
                lb_pending.bringToFront()


                // link box Reject -----
                if (lb_reject != '') {
                    map.removeLayer(lb_reject)
                }

                lb_reject = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                    layers: 'cite:lb_reject',
                    format: 'image/png',
                    cql_filter: q_cql,
                    maxZoom: 21,
                    transparent: true
                }, {
                    buffer: 10
                })


                map.addLayer(lb_reject)
                lb_reject.bringToFront()

                // link box unsurvey  -----

                if (lb_unsurveyed != '') {
                    map.removeLayer(lb_unsurveyed)
                }
                lb_unsurveyed = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                    layers: 'cite:lb_unsurveyed',
                    format: 'image/png',
                    cql_filter: "ba ILIKE '%" + param + "%'",
                    maxZoom: 21,
                    transparent: true
                }, {
                    buffer: 10
                })

                map.addLayer(lb_unsurveyed)
                lb_unsurveyed.bringToFront()

            // }

            addGroupOverLays()

        }


        // add group overlayes
        function addGroupOverLays() {
            if (layerControl != '') {
                // console.log("inmsdanssdkjnasjnd");
                map.removeControl(layerControl);
            }

            // if (ba !== '') {


                groupedOverlays = {
                    "POI": {
                        'BA': boundary,
                        'Pano': pano_layer,
                        'With defects': lb_with_defects,
                        'Without defects': lb_without_defects,
                        'Unsurveyed': lb_unsurveyed,

                        'Work Package': work_package,
                        'Pending': lb_pending,
                        'Reject': lb_reject
                    }
                };
            // } else {

            //     groupedOverlays = {
            //         "POI": {
            //             'BA': boundary,
            //             'Pano': pano_layer,
            //             'With defects': lb_with_defects,
            //             'Without defects': lb_without_defects,
            //             'Work Package': work_package,
            //         }
            //     };

            // }
            //add layer control on top right corner of map
            layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
                collapsed: true,
                position: 'topright'
                // groupCheckboxes: true
            }).addTo(map);
        }






        function showModalData(data, id) {
            // var str = '';
            // var idSp = id.split('.');
            // var vDS = '';
            // if (data.visit_date != '' && data.visit_date != null) {
            //     var sDate = data.visit_date.split('T');
            //     console.log(sDate[0]);
            //     vDS = sDate[0]
            // }
            // var vTM = '';
            // if (data.patrol_time != '' && data.patrol_time != null) {
            //     var VTime = data.patrol_time.split('T');

            //     vTM = VTime[1]
            // }


            //     $('#exampleModalLabel').html("Link Box Info")
            //     str = ` <tr>
        //         <tr><th>Zone</th><td>${data.zone}</td> </tr>
        // <tr><th>Ba</th><td>${data.ba}</td> </tr>
        // <tr><th>Area</th><td>${data.area}</td> </tr>

        // <tr><th>Visit Date</th><td>${vDS}</td> </tr>
        // <th>Patrol TIme</th><td>${vTM}</td> </tr>

        // <tr><th>Coordinate</th><td>${data.coordinate}</td> </tr>
        // <tr><th>Created At</th><td>${data.created_at}</td> </tr>
        // <tr><th>Detail</th><td class="text-center">    <a href="/{{ app()->getLocale() }}/link-box-pelbagai-voltan/${idSp[1]}" target="_blank" class="btn btn-sm btn-secondary">Detail</a>
        //     </td> </tr>

        // `

            // $("#my_data").html(str);
            // $('#myModal').modal('show');

            openDetails(data.id);

        }

        function openDetails(id) {
            // $('#myModal').modal('hide');
            $('#set-iframe').html('');

            $('#set-iframe').html(
                `<iframe src="/{{ app()->getLocale() }}/get-link-box-edit/${id}" frameborder="0" style="height:700px; width:100%" ></iframe>`
            )


        }
    </script>
@endsection
