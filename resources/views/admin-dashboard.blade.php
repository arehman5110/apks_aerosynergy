@extends('layouts.app')
@section('css')
    @include('partials.map-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        h3 {
            font-weight: 600
        }

        .collapse .card-body {
            padding: 0px !important
        }

        h3 {
            color: #7379AE;
            font-size: 20px !important;
        }

        .accordion .card {
            background: #d1cfcf14;
        }

        .dashboard-counts h3 {
            font-size: 1rem !important
        }

        .dashboard-counts p {
            font-weight: 600;
            color: slategrey;
        }

        .form-input {
            padding: 0 10px 0 0;

            border: 0px;
        }
    </style>
@endsection
@section('content')
    @if (Auth::user()->ba == '')
        <div class=" px-4  mt-2  from-input  ">
            <div class="card p-0 mb-3">
                <div class="card-body row">

                    <div class=" col-md-3">
                        <label for="excelZone">Zone :</label>
                        <select name="excelZone" id="excelZone" class="form-control" onchange="getBa(this.value)">
                            <option value="" hidden>
                                Select Zone
                            </option>

                            <option value="W1">W1</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="B4">B4</option>

                        </select>
                    </div>
                    <div class=" col-md-3">
                        <label for="excelBa">BA :</label>
                        <select name="excelBa" id="excelBa" class="form-control" onchange="onChangeBA(this.value)">


                        </select>
                    </div>
                    <div class=" col-md-2 form-input">
                        <label for="excel_from_date">From Date : </label>
                        <input type="date" name="excel_from_date" id="excel_from_date" class="form-control"
                            onchange="setMinDate(this.value)">
                    </div>
                    <div class=" col-md-2 form-input">
                        <label for="excel_to_date">To Date : </label>
                        <input type="date" name="excel_to_date" id="excel_to_date" onchange="setMaxDate(this.value)"
                            class="form-control">
                    </div>
                    <div class="col-md-2 pt-2">
                        <br>
                        <button class="btn btn-secondary  " type="button" onclick="resetDashboard()">Reset</button>
                    </div>



                </div>
            </div>
        </div>



        <div class=" d-sm-flex px-4    ">
            <div class="col-md-6 ">
                
            <div class="card p-0">
                <div class="card-header">

                    <h3 class="card-title">Total Pending and Surveyed</h3>

                    <div class="card-tools">

                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>

                    </div>
                </div>

                    <div class="card-body from-input">

                        <div class="table-responsive  ">
                            <table class="table" id="stats_table_1">
                                <thead>
                                    <tr>

                                        <th scope="col" rowspan="2">BA</th>
                                        <th scope="col" rowspan="2">Patroling(KM)</th>
                                        <th scope="col">Substation</th>
                                        <th scope="col">Feeder Pillar</th>
                                        <th scope="col">Tiang</th>
                                        <th scope="col">Link Box</th>
                                        <th scope="col">Cable Bridge</th>
                                    </tr>
                            
                                </thead>

                                <tbody id='stats_table'>

                                </tbody>
                                <tfoot id='stats_table_footer'>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-header">
                        <h3 class="card-title">Map</h3>
                        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id='map' style="width:100%;height:800px;"  >

                        </div>
                    </div>
                </div>
            </div>
            </div>
         
    @endif
    <div class=" px-4 mt-2">
        <div class="row dashboard-counts">
            {{-- <div class="col-md-2">
        <div class="card p-3">

                <h3 class="text-center">   3rd Party Digging </h3>
                <p class="text-center mb-0 pb-0"><span>0</span></p>

          </div>
    </div> --}}
 
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title text-white">{{ __('messages.patroling') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_patrollig_done') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="total_km"> </span> KM
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">

                                    <h3 class="text-center">{{ __('messages.total_notice_generated') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="total_notice"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_supervision') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="total_supervision"></span>
                                    </p>

                                </div>
                            </div>

 
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div id="patrolling-container" class="high-chart" style="width:100%; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header text-white">{{ __('messages.substation') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_substation_visited') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="substation"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_substation_defects') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span
                                            id="substation_defect"></span></p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_substation_pending') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="substation_pending"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_substation_accept') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="substation_accept"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_substation_reject') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="substation_reject"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class="card p-3">
                                    <div id="suryed_substation-container" style="width:100%; height: 400px; margin: 0 auto"   class="high-chart" ></div>
                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class="card p-3">
                                    <div id="substation-container" style="width:100%; height: 400px; margin: 0 auto"   class="high-chart" ></div>
                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class="card p-3">
                                    <div id="pending_substation-container" style="width:100%; height: 400px; margin: 0 auto"   class="high-chart" ></div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">{{ __('messages.feeder_pillar') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center">{{ __('messages.total_feeder_pillar_visited') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="feeder_pillar"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_defects') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="feeder_pillar_defect"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_pending') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="feeder_pillar_pending"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_accept') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="feeder_pillar_accept"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_reject') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="feeder_pillar_reject"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_feeder_pillar-container"
                                        style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="feeder_pillar-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_feeder_pillar-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" >
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">{{ __('messages.tiang') }}</div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center">{{ __('messages.total_tiang_visited') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="tiang"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_tiang_defects') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="tiang_defect"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_tiang_pending') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="tiang_pending"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_tiang_accept') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="tiang_accept"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_tiang_reject') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="tiang_reject"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_tiang-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="tiang-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_tiang-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">{{ __('messages.link_box') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_link_box_visited') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="link_box"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_link_box_defects') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="link_box_defect"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_link_box_pending') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="link_box_pending"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_link_box_accept') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="link_box_accept"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_link_box_reject') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="link_box_reject"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_link_box-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="link_box-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_link_box-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card card-danger">
                    <div class="card-header"> {{ __('messages.cable_bridge') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_visited') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="cable_bridge"></span>
                                    </p>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_defects') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="cable_bridge_defect"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_pending') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="cable_bridge_pending"></span>
                                    </p>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_accept') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="cable_bridge_accept"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="card p-3">

                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_reject') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="cable_bridge_reject"></span>
                                    </p>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_cable_bridge-container"
                                        style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="cable_bridge-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_cable_bridge-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('script')
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>


    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    @include('partials.map-js')


    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>


    {{-- MAP START   --}}

    <script>
        var patroling = '';

        var patrol = [];

        var from_date = $('#excel_from_date').val();
        var to_date = $('#excel_to_date').val();
        var excel_ba = $('#search_ba').val();

        zoom = 9;

        function addRemoveBundary(param, paramY, paramX) {

            var q_cql = "ba ILIKE '%" + param + "%' "
            var t_cql = q_cql;
            var p_cql = q_cql;
            if (from_date != '') {
                q_cql = q_cql + "AND visit_date>=" + from_date;
                t_cql = t_cql + "AND review_date>=" + from_date;
                p_cql = p_cql + "AND vist_date>=" + from_date;

            }
            if (to_date != '') {
                q_cql = q_cql + "AND visit_date<=" + to_date;
                t_cql = t_cql + "AND review_date<=" + to_date;
                p_cql = p_cql + "AND vist_date<=" + to_date;


            }


            // add boundary
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


            // zoom to map
            map.flyTo([parseFloat(paramY), parseFloat(paramX)], zoom, {
                duration: 1.5, // Animation duration in seconds
                easeLinearity: 0.25,
            });


            //  add patrolling layer

            if (patroling !== '') {
                map.removeLayer(patroling)
            }


            patroling = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:patroling_lines',
                format: 'image/png',
                cql_filter: p_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })
            map.addLayer(patroling)
            patroling.bringToFront()

            // add pano layer

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

            //  add work package

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



            if (substation_with_defects != '') {
                map.removeLayer(substation_with_defects)
            }

            substation_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:surved_with_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })


            map.addLayer(substation_with_defects)
            substation_with_defects.bringToFront()




            if (substation_without_defects != '') {
                map.removeLayer(substation_without_defects)
            }
            substation_without_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:substation_without_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(substation_without_defects)
            substation_without_defects.bringToFront()



            if (sub_reject != '') {
                    map.removeLayer(sub_reject)
                }

                sub_reject = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                    layers: 'cite:sub_reject',
                    format: 'image/png',
                    cql_filter: q_cql,
                    maxZoom: 21,
                    transparent: true
                }, {
                    buffer: 10
                })


                map.addLayer(sub_reject)
                sub_reject.bringToFront()


                if (sub_pending != '') {
                    map.removeLayer(sub_pending)
                }

                sub_pending = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                    layers: 'cite:sub_pending',
                    format: 'image/png',
                    cql_filter: q_cql,
                    maxZoom: 21,
                    transparent: true
                }, {
                    buffer: 10
                })


                map.addLayer(sub_pending)
                sub_pending.bringToFront()

                if (unservey != '') {
                    map.removeLayer(unservey)
                }
                unservey = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                    layers: 'cite:sub_unserveyed',
                    format: 'image/png',
                    cql_filter: "ba ILIKE '%" + param + "%'",
                    maxZoom: 21,
                    transparent: true
                }, {
                    buffer: 10
                })

                map.addLayer(unservey)
                unservey.bringToFront()








            if (fp_with_defects != '') {
                map.removeLayer(fp_with_defects)
            }

            fp_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:fp_with_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(fp_with_defects)
            fp_with_defects.bringToFront()


            if (fp_without_defects != '') {
                map.removeLayer(fp_without_defects)
            }

            fp_without_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:fp_without_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(fp_without_defects)
            fp_without_defects.bringToFront()


            if (fp_reject != '') {
                map.removeLayer(fp_reject)
            }

            fp_reject = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:fp_reject',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })


            map.addLayer(fp_reject)
            fp_reject.bringToFront()


            if (fp_pending != '') {
                map.removeLayer(fp_pending)
            }

            fp_pending = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:fp_pending',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })


            map.addLayer(fp_pending)
            fp_pending.bringToFront()

            if (fp_unsurveyed != '') {
                map.removeLayer(fp_unsurveyed)
            }
            fp_unsurveyed = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:fp_unsurveyed',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(fp_unsurveyed)
            fp_unsurveyed.bringToFront()

            if (road != '') {
                map.removeLayer(road)
            }

            road = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:tbl_roads',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })
            map.addLayer(road)
            road.bringToFront()




            if (ts_with_defects != '') {
                map.removeLayer(ts_with_defects)
            }

            ts_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ts_with_defects',
                format: 'image/png',
                cql_filter: t_cql,
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
                cql_filter: t_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(ts_without_defects)
            ts_without_defects.bringToFront()


            if (lb_with_defects != '') {
                map.removeLayer(lb_with_defects)
            }

            lb_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:lb_with_defects',
                format: 'image/png',
                cql_filter: "ba ILIKE '%" + param + "%'",
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(lb_with_defects)
            lb_with_defects.bringToFront()


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


            if (cb_without_defects != '') {
                map.removeLayer(cb_without_defects)
            }

            cb_without_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:cb_without_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(cb_without_defects)
            cb_without_defects.bringToFront()


            if (cb_with_defects != '') {
                map.removeLayer(cb_with_defects)
            }

            cb_with_defects = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:cb_with_defects',
                format: 'image/png',
                cql_filter: q_cql,
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(cb_with_defects)
            cb_with_defects.bringToFront()






            // addpanolayer();
            addGroupOverLays()

            if (patrol) {
                for (let i = 0; i < patrol.length; i++) {
                    if (patrol[i] != '') {
                        map.removeLayer(patrol[i])
                    }
                }
            }

        }



        function addGroupOverLays() {
            if (layerControl != '') {
                // console.log("inmsdanssdkjnasjnd");
                map.removeControl(layerControl);
            }
            // console.log("sdfsdf");
            groupedOverlays = {
                "POI": {
                    'Boundary': boundary,
                    'Patrolling': patroling,
                    'Pano': pano_layer,
                    'Roads': road,

                    'Substation With defects': substation_with_defects,
                    'Substation Without defects': substation_without_defects,
                    'Substation Pending': sub_pending,
                    'Substation Reject': sub_reject,
                    'Substation Unsurveyed': unservey,

                    'Pano': pano_layer,
                    'Work Package': work_package,

                    'Feeder Pillar Surveyed with defects': fp_with_defects,
                    'Feeder Pillar Surveyed Without defects': fp_without_defects,
                    'Feeder Pillar Pending':fp_pending,
                    'Feeder Pillar Reject':fp_reject,
                    'Feeder Pillar Unsurveyed': fp_unsurveyed,

                    'Tiang Surveyed with defects': ts_with_defects,
                    'Tiang Surveyed Without defects': ts_without_defects,
                    'Link Box Surveyed with defects': lb_with_defects,
                    'Link BoxSurveyed  without defects': lb_without_defects,
                    'Cable Bridge Surveyed with defects': cb_with_defects,
                    'Cable Bridge Surveyed without defects': cb_without_defects,
                }
            };
            //add layer control on top right corner of map
            layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
                collapsed: true,
                position: 'topright'
                // groupCheckboxes: true
            }).addTo(map);
        }


        $(function() {
            // $('#stats_table').DataTable()
            if ('{{ Auth::user()->ba }}' == '') {
                getAllStats()
            }

            $('#excel_from_date , #excel_to_date').on('change', function() {
                var ff_ba = $('#excelBa').val() ?? '';
                from_date = $('#excel_from_date').val() ?? null;
                to_date = $('#excel_to_date').val() ?? null;

                onChangeBA();
                // getAllStats();
                callLayers(ff_ba)

            })


        })
    </script>

    {{-- MAP END --}}







    {{-- Charts Start --}}

    <script>
        function onChangeBA(param) {

            // clear all charts

            $('.high-chart').html('');
            

            getDateCounts();
            getAllStats();
            callLayers(param);
        }


        function mainBarChart(cat, series, id, tName) {
            var barName = '';
            var titleName = 'Total ' + tName;
            if (id == "patrolling-container") {
                barName = 'KM'
                titleName = 'KM Patrol'
            }
            Highcharts.chart(id, {
                chart: {
                    type: 'column'
                },
                credits: false,

                title: {
                    text: 'Total ' + tName
                },
                subtitle: {
                    text: 'Source:Aerosynergy'
                },
                xAxis: {
                    categories: cat,
                    min: 0,
                    max: 3,
                    scrollbar: {
                        enabled: true
                    },

                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: titleName
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: `<tr><td style="color:{series.color};padding:0">{series.name}: </td>` +
                        `<td style="padding:0"><b>{point.y:f}</b>${barName}</td></tr>`,
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: series
            });
        }




        function getDateCounts() {

            var cu_ba = $('#excelBa').val() ?? 'null';
            var from_datee = $('#excel_from_date').val() ?? '';
            var to_datee = $('#excel_to_date').val() ?? '';



            $.ajax({
                url: `/{{ app()->getLocale() }}/patrol_graph?ba=${cu_ba}&from_date=${from_datee}&to_date=${to_datee}`,

                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data) {


                    if (data && data['patrolling'] != '') {
                        makeArray(data['patrolling'], 'patrolling-container', '')
                    }

                    const counts = ['substation' , 'feeder_pillar' , 'link_box' , 'cable_bridge' , 'tiang']

                    for (let index = 0; index < 5; index++) {


                        makeArray(data[counts[index]] , `${counts[index]}-container` , "Defects" );

                        makeArray(data['suryed_'+counts[index]] , `suryed_${counts[index]}-container` , "Visited" );

                        makeArray(data['pending_'+counts[index]] , `pending_${counts[index]}-container` , "Pending" );

                        
                    }


                }
            });



            $.ajax({
                url: `/{{ app()->getLocale() }}/admin-get-all-counts?ba=${cu_ba}&from_date=${from_datee}&to_date=${to_datee}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data) {

                    for (var key in data) {
                        $("#" + key).html(data[key]);
                    }
                }
            });


        }

        function makeTotalArray(arr, id) {

            console.log(arr);
            var cate = arr.map(item => item.ba);
            var seriesD = arr.map(item => item.count);

            var series = [{
                name: 'Count',
                data: seriesD
            }];

            console.log(series);
            mainBarChart(cate, series, id, 'Counts');


        }


        function makeArray(data, id, tName) {


            var series = [];
            var temp = [];
            var cat = [];
            for (var k = 0; k < data.length; k++) {
                if (cat.includes(data[k].visit_date) == false) {
                    cat.push(data[k].visit_date)
                }
            }
            for (var i = 0; i < data.length; i++) {
                // if(cat.includes(data[i].updated_at)==false){
                //     cat.push(data[i].updated_at)
                // }
                var username = data[i].ba;
                if (temp.includes(username) == true) {
                    continue;
                } else {
                    temp.push(username);
                    var obj = {};
                    obj.name = username;
                    var arr = []
                    for (var j = 0; j < data.length; j++) {
                        if (data[j].ba == username) {
                            var len = 0;
                            if (arr.length > 0) {
                                len = arr.length;
                            }
                            //if(data[j].updated_at==cat[len]){
                            var index = cat.indexOf(data[j].visit_date);
                            if (index > len) {
                                for (g = len; g < index; g++) {
                                    arr.push(0)
                                }
                                arr.push(parseInt(data[j].bar));
                            } else {
                                arr.push(parseInt(data[j].bar));
                            }
                            // }else{
                            //     arr.push(0)
                            // }
                        }

                    }
                    obj.data = arr;
                    series.push(obj)
                }

            }
            // console.log(series);
            mainBarChart(cat, series, id, tName)


        }
    </script>

    {{-- CHARTS END --}}


    {{-- COUNTS START --}}

    <script>
        function getAllStats() {
            let todaydate = '{{ date('Y-m-d') }}';



            var cu_ba = $('#excelBa').val() ?? 'null';
            if ($('#excel_from_date').val() == '') {
                var from_datee = '1970-01-01'
            } else {
                var from_datee = $('#excel_from_date').val();
            }
            if ($('#excel_to_date').val() == '') {
                var to_datee = todaydate
            } else {
                var to_datee = $('#excel_to_date').val();
            }

            $.ajax({
                url: `/{{ app()->getLocale() }}/admin-statsTable?ba_name=${cu_ba}&from_date=${from_datee}&to_date=${to_datee}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data) {
                    var table = data.data;
                    var table_footer = data.sum;
                    // console.log(data.sum.substation.pending);

                    // Destroy existing DataTable instance (if any)

                    if ($.fn.DataTable.isDataTable('#stats_table_1')) {
                        $('#stats_table_1').DataTable().destroy();
                    }

                    var str = '';
                    

                    for (var i = 0; i < table.length; i++) {
                        str += '<tr><td>' + table[i].ba + '</td><td>' + table[i].patroling + '</td><td>' +
                            table[i].substation + '</td><td>' + table[i].feeder_pillar + '</td><td>' + table[i]
                            .tiang + '</td><td>' +
                                table[i].link_box + '</td><td>' + table[i].cable_bridge + '</td></tr>';

                      
                    }

                    $('#stats_table').html(str);



                    var str2 = '<tr><th>Total</th>';

                        str2 += `<th>${parseFloat(table_footer['patroling']).toFixed(2)}</th>`;
                        str2 += `<th>${table_footer.substation.pending} / ${table_footer.substation.surveyed} </th>`;
                        str2 += `<th>${table_footer.feeder_pillar.pending} / ${table_footer.feeder_pillar.surveyed} </th>`;
                        str2 += `<th>${table_footer.tiang.pending} / ${table_footer.tiang.surveyed} </th>`;
                        str2 += `<th>${table_footer.link_box.pending} / ${table_footer.link_box.surveyed} </th>`;
                        str2 += `<th>${table_footer.cable_bridge.pending} / ${table_footer.cable_bridge.surveyed} </th>`;
                        str += '</tr>'


                    

                    $('#stats_table_footer').html(str2);

                    // Reinitialize DataTable with new options
                    $('#stats_table_1').DataTable({
                        searching: false, // Disable search bar
                        paging: false // Disable pagination
                    });


                }

            });
        }


        function resetDashboard() {
            $('#excelBa').empty();
            $('#excel_from_date, #excel_to_date ').val('');
            onChangeBA();
            from_date = '';
            to_date = '';

            if (ba == '') {
                addRemoveBundary('', 2.75101756479656, 101.304931640625)
            } else {
                callLayers(ba);
            }
            // $("#excelBa").val($("#excelBa option:first").val());
        }


        setTimeout(() => {
            getDateCounts();
        }, 1000);
    </script>

    {{-- COUNTS END --}}
@endsection
