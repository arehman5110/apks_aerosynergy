@extends('layouts.app', ['page_title' => 'Index'])

@section('css')
    @include('partials.map-css')
    <style>
        #map {
            height: 700px;
        }


        /* .main-sidebar{width: 220px }
                body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header  {margin-left: 220px }
                .content-wrapper{margin-left: 220px !important} */
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
                    <h3>Tiang + Talian VT & VR</h3>
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
                    <select name="search_zone" id="search_zone" class="form-control"
                        onchange="onChangeZone(this.value)">

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
                {{-- <div class="px-3 d-flex">
                    <input type="radio" name="select_layer" id="ts_unsurveyed" class="unsurveyed m-1" value="ts_unsurveyed" onchange="selectLayer(this.value)">
                    <label for="ts_unsurveyed">Unsurveyed</label>
                </div> --}}

                <div class="px-3 d-flex">

                    <input type="radio" name="select_layer" id="ts_with_defects" class="with_defects m-1" value="ts_with_defects" onchange="selectLayer(this.value)">
                    <label for="ts_with_defects">Surveyed with defects</label>
                </div>

                <div class="px-3 d-flex">

                    <input type="radio" name="select_layer" id="ts_without_defects" class="without_defects m-1" value="ts_without_defects" onchange="selectLayer(this.value)">
                    <label for="ts_without_defects">Surveyed without defects</label>
                </div>


                  <div class=" mx-4">
                    <input type="radio" name="select_layer" id="ts_layer_pending" value="ts_pending"
                        onchange="selectLayer(this.value)" class="pending">
                    <label for="select_layer_pending">Pending </label>
                </div>

{{-- 
                <div class=" mx-4">
                    <input type="radio" name="select_layer" id="ts_layer_reject" value="ts_reject"
                        onchange="selectLayer(this.value)" class="reject">
                    <label for="select_layer_reject">Reject </label>
                </div>   --}}


                <div class="px-3 d-flex">

                    <input type="radio" name="select_layer" id="select_layer_pano" class="m-1 pano" value="pano" onchange="selectLayer(this.value)">
                    <label for="select_layer_pano">Pano</label>
                </div>


            <div class="mx-4">
                <div id="the-basics">
                    <input class="typeahead" type="text" placeholder="search by tiang no" class="form-control">
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



                        <details class="mb-3" open>
                            <summary><strong> Tiang + Talian VT & VR</strong> </summary>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Pendaftaran aset, pemeriksaan visual</td>
                                </tr>
                                <tr>
                                    <td>Pembersihan iklan haram/banner</td>
                                </tr>
                                <tr>
                                    <td>Pembersihan creepers</td>
                                </tr>
                                <tr>
                                    <td>Pemeriksaan kebocoran arus pada tiang</td>
                                </tr>
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
                    url: '/{{ app()->getLocale() }}/search/find-tiang/' + q,
                    dataType: 'JSON',
                    //data: data,
                    method: 'GET',
                    async: false,
                    success: function callback(data) {
                        $.each(data, function(i, str) {

                            matches.push(str.tiang_no);

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
                url: '/{{ app()->getLocale() }}/search/find-tiang-cordinated/' + encodeURIComponent(
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


            var q_cql = "ba ILIKE '%" + param + "%' "
            if (from_date != '') {
                q_cql = q_cql + "AND review_date >=" + from_date;
            }
            if (to_date != '') {
                q_cql = q_cql + "AND review_date <=" + to_date;
            }

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

            map.flyTo([parseFloat(paramY), parseFloat(paramX)], zoom, {
                duration: 1.5, // Animation duration in seconds
                easeLinearity: 0.25,
            });


            if (substation != '') {
                map.removeLayer(substation)
            }

            substation = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:tbl_substation',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            // map.addLayer(substation)
            // substation.bringToFront()

            road = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:tbl_roads',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })
            // map.addLayer(road)
            // road.bringToFront()



            // if (ts_unsurveyed != '') {
            //     map.removeLayer(ts_unsurveyed)
            // }

            // ts_unsurveyed = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
            //     layers: 'cite:ts_unsurveyed',
            //     format: 'image/png',
            //     cql_filter: "ba ILIKE '%" + param + "%'",
            //     maxZoom: 21,
            //     transparent: true
            // }, {
            //     buffer: 10
            // })

            // map.addLayer(ts_unsurveyed)
            // ts_unsurveyed.bringToFront()


            if (ts_with_defects != '') {
                map.removeLayer(ts_with_defects)
            }

            ts_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ts_with_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(ts_with_defects)
            ts_with_defects.bringToFront()

            if (ts_without_defects != '') {
                map.removeLayer(ts_without_defects)
            }

            ts_without_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ts_without_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(ts_without_defects)
            ts_without_defects.bringToFront()

            if (ts_pending !== '') {
                map.removeLayer(ts_pending)
            }

            ts_pending= L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ts_pending',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(ts_pending)
            ts_pending.bringToFront()

            // ts_reject = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
            //     layers: 'cite:ts_reject',
            //     format: 'image/png',
            //     cql_filter: q_cql,
            //     maxZoom: 21,
            //     transparent: true
            // }, {
            //     buffer: 10
            // })

            // map.addLayer(ts_reject)
            // ts_reject.bringToFront()


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


            if(work_package){
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
            work_package.bringToFront()


            addGroupOverLays()

        }


        // add group overlayes
        function addGroupOverLays() {
            if (layerControl != '') {
                // console.log("inmsdanssdkjnasjnd");
                map.removeControl(layerControl);
            }
            // console.log("sdfsdf");
            groupedOverlays = {
                "POI": {
                    'BA': boundary,
                    'Substation': substation,
                    'Pano': pano_layer,
                //    'Unsurveyed' : ts_unsurveyed,
                    'Surveyed with defects' : ts_with_defects,
                    'Surveyed Without defects' : ts_without_defects,
                   'Surveyed Pending' : ts_pending,
                //    'Surveyed Rejected' : ts_reject,
                    'Roads': road,
                    'Work Package':work_package

                }
            };
            //add layer control on top right corner of map
            layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
                collapsed: true,
                position: 'topright'
                // groupCheckboxes: true
            }).addTo(map);
        }

        function roadModal(data, id) {

            var str = '';
            gid = id.split('.')

            $('#exampleModalLabel').html("Road Info")
            str = ` <tr>
        <tr><th>Road Name</th><td>${data.road_name}</td> </tr>
        <tr><th>KM</th><td>${data.km}</td> </tr>

        <tr><th>Totoal Digging</th><td>${data.total_digging}</td> </tr>
        <tr><th>Total Notice</th><td>${data.total_notice}</td> </tr>
        <th>Total Supervision</th><td>${data.total_supervision}</td> </tr>

        <tr><th>Detail</th><td class="text-center"><a href="/{{ app()->getLocale() }}/patrolling-detail/${gid[1]}" target="_blank" class="btn btn-sm btn-secondary">Detail</a>
            </td> </tr>

        `;
            $("#my_data").html(str);
            $('#myModal').modal('show');
        }

        function showModalData(data, id) {
//             var str = '';
//             gid = id.split('.')
//             console.log(gid);
//             $('#exampleModalLabel').html("Tiang Info")
//             str = ` <tr>
//         <tr><th>Ba</th><td>${data.ba}</td> </tr>
//         <tr><th>Section From</th><td>${data.section_from}</td> </tr>
//         <tr><th>Section To</th><td>${data.section_to}</td> </tr>
//         <th>Actual Date</th><td>${data.actual_date}</td> </tr>
//         <th>Planed Date</th><td>${data.planed_date}</td> </tr>

//         <tr><th>Coordinate</th><td>${data.coordinate}</td> </tr>
//         <tr><th>Created At</th><td>${data.created_at}</td> </tr>
//         <tr><th>Detail</th><td class="text-center">    <button type="button" onclick="openDetails(${gid[1]})" class="btn btn-sm btn-secondary">Edit</button>
// </td></tr>
//         <tr><th>Detail</th><td class="text-center">    <a href="/{{ app()->getLocale() }}/tiang-talian-vt-and-vr/${gid[1]}" target="_blank" class="btn btn-sm btn-secondary">Detail</a>
//             </td> </tr>
//         `
            // $("#my_data").html(str);
            // $('#myModal').modal('show');
            openDetails(data.id)

        }

        function openDetails(id) {
            // $('#myModal').modal('hide');
            $('#set-iframe').html('');

            $('#set-iframe').html(
                `<iframe src="/{{ app()->getLocale() }}/get-tiang-edit/${id}" frameborder="0" style="height:700px; width:100%" ></iframe>`
                )


        }
    </script>
@endsection
