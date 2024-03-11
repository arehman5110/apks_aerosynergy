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
        .table-responsive::-webkit-scrollbar {
  width: 5px; /* Set the width of the scrollbar */
}
.table-responsive::-webkit-scrollbar-track {
  background-color: #f1f1f1; /* Set the color of the track */
}

.table-responsive::-webkit-scrollbar-thumb {
  background-color: #9f9f9f; /* Set the color of the thumb */
  border-radius: 6px; /* Add rounded corners to the thumb */
}

.table-responsive::-webkit-scrollbar-thumb:hover {
  background-color: #747474; /* Change the color on hover */
}


#loader {
    position: fixed; 
    z-index: 1002;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
   
}

#overlay2 {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.897); 
    backdrop-filter: blur(0.5px); 
    display: none;
    z-index: 1001;  
}
 
.loader {
  font-weight: bold;
  font-family: monospace;
  font-size: 30px;
  line-height: 1.2em;
  display: inline-grid;
}
.loader:before,
.loader:after {
  content:"Loading...";
  grid-area: 1/1;
  -webkit-mask: linear-gradient(90deg,#000 50%,#0000 0) 0 50%/2ch 100%;
  color: #0000;
  text-shadow: 0 0 0 #000,0 calc(var(--s,1)*1.2em) 0 #000;
  animation: l15 1s infinite;
}
.loader:after {
  -webkit-mask-position: 1ch 50%;
  --s:-1;
}
@keyframes l15 {80%,100%{text-shadow:0 calc(var(--s,1)*-1.2em)  0 #000,0 0 0 #000}}


    </style>
@endsection
@section('content')


<div id="overlay2"  ></div>

 
<div id="loader"   >
    <div class="loader"></div>
    {{-- <div class="d-flex flex-column justify-content-center align-items-center gap-2">
        <img id="spinner" src="{{URL::asset( 'assets/web-images/loader.svg')}}" height="50" width="50" />
        <span>loading... please wait!</span>
    </div> --}}
</div>

     
@if (Auth::user()->ba == '')
    

        {{-- FILTER START --}}
        <div class=" px-4  mt-2  from-input  ">
            <div class="card p-0 mb-3">
                <div class="card-body row">
                    
                    {{-- ZONE --}}
                    <div class=" col-md-2">
                        <label for="excelZone">Zone :</label>
                        <select name="excelZone" id="excelZone" class="form-control" onchange="getBa(this.value)">
                            @if (Auth::user()->ba != '')
                            <option value="{{Auth::user()->zone}}" hidden>{{Auth::user()->zone}}</option>
                            @else
                            <option value="" hidden>Select Zone</option>
                            <option value="W1">W1</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="B4">B4</option>
                            @endif
                        </select>
                    </div>

                    {{-- BA --}}
                    <div class=" col-md-2">
                        <label for="excelBa">BA :</label>
                        <select name="excelBa" id="excelBa" class="form-control" onchange="onChangeBA(this.value)">
                            @if (Auth::user()->ba != '')
                                <option value="{{Auth::user()->ba}}" hidden>{{Auth::user()->ba}}</option>
                            @endif
                        </select>
                    </div>

                    {{-- TEAM --}}
                    <div class=" col-md-2">
                        <label for="team">TEAM :</label>
                        <select name="team" id="team" class="form-control" onchange="onChangeTeam(this.value)">
                            <option value="" hidden>select team</option>
                            @foreach ($teams as $team)
                                <option value="{{$team->id}}">{{$team->team_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- USER --}}
                    <div class=" col-md-2">
                        <label for="excelBa">USER :</label>
                        <select name="user" id="user" class="form-control" onchange="onChangeBA()">
                            <option value="">select user</option>
                        </select>
                    </div>

                    {{-- FROM DATE --}}
                    <div class=" col-md-2 form-input">
                        <label for="excel_from_date">From Date : </label>
                        <input type="date" name="excel_from_date" id="excel_from_date" class="form-control" onchange="setMinDate(this.value)">
                    </div>

                    {{-- TO DATE --}}
                    <div class=" col-md-2 form-input">
                        <label for="excel_to_date">To Date : </label>
                        <input type="date" name="excel_to_date" id="excel_to_date" onchange="setMaxDate(this.value)" class="form-control">
                    </div>

                    {{-- RESET BUTTON --}}
                    <div class="col-md-2 pt-2">
                        <br>
                        <button class="btn btn-secondary  " type="button" onclick="resetDashboard()">Reset</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- END FILTER --}}



        <div class=" row px-4 ">

            {{-- TABLE COUNTS START --}}
            <div class="col-md-12 ">
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
                        <div class="table-responsive  " style="height:100vh;">
                            <table class="table" id="stats_table_1" >
                                <thead>
                                    <tr>
                                        <th scope="col" >Ba</th>
                                        <th scope="col" >Patroling(KM)</th>
                                        <th scope="col">Substation</th>
                                        <th scope="col">Feeder Pillar</th>
                                        <th scope="col">Tiang</th>
                                        <th scope="col">Link Box</th>
                                        <th scope="col">Cable Bridge</th>
                                        <th scope="col">Total</th>
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
            {{-- TABLE COUNTS END --}}

            


            {{-- COUNTS BY USER --}}

            <div class="col-md-12 ">
                <div class="card p-0">
                    <div class="card-header">
                        <h3 class="card-title">Total Counts By Users</h3>
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
                        <div class="table-responsive  " style="max-height:100vh;">
                            <table class="table" id="stats-count-by-users" >
                                <thead>
                                    <tr>
                                        <th scope="col" >User</th>
                                        <th scope="col" >Patroling(KM)</th>
                                        <th scope="col">Substation</th>
                                        <th scope="col">Feeder Pillar</th>
                                        <th scope="col">Tiang</th>
                                        <th scope="col">Link Box</th>
                                        <th scope="col">Cable Bridge</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody id='stats-count-by-users-body'>

                                </tbody>
                                <tfoot id='stats-count-by-users-footer'>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- END COUNTS BY USER --}}

           

           
            {{-- MAP START --}}
            <div class="col-md-12  ">
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
                        <div id='map' style="width:100%;height:100vh;"  >

                        </div>
                    </div>
                </div>
            </div>
            {{-- MAP END --}}


        </div>
    
        @endif
         

    <div class=" px-4 mt-2">
        <div class="row dashboard-counts">
            {{-- PATROLLING START --}}
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
                            {{-- TOTAL PATROLLING DONE --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_patrollig_done') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="total_km"> </span> KM</p>
                                </div>
                            </div>
                            {{-- TOTAL NOTICE GENERATED --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h3 class="text-center">{{ __('messages.total_notice_generated') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="total_notice"></span>
                                    </p>
                                </div>
                            </div>
                            {{-- TOTAL SUPERVISION --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_supervision') }} </h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="total_supervision"></span>
                                    </p>
                                </div>
                            </div>

                            {{-- PATROLLING BAR CAHRT --}}
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div id="patrolling-container" class="high-chart" style="width:100%; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- PATROLLING END --}}


            {{-- SUBSTATION START --}}
            <div class="col-md-12">
                <div class="card card-warning">

                    <div class="card-header text-white">{{ __('messages.substation') }}</div>

                    <div class="card-body">
                        <div class="row">

                            {{-- TOTAL SUBSTATION VISITED --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_substation_visited') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="substation"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL SUBSTATION DEFECTS --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_substation_defects') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="substation_defect"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL SUBSTATION PENDING --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_substation_pending') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="substation_pending"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL SUBSTATION ACCEPT --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_substation_accept') }}</h3>
                                    <p class="text-center mb-0 pb-0">
                                        <span id="substation_accept"></span>
                                    </p>

                                </div>
                            </div>

                            {{-- SURYED SUBSTATION --}}
                            <div class="col-md-4 ">
                                <div class="card p-3">
                                    <div id="suryed_substation-container" style="width:100%; height: 400px; margin: 0 auto"   class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- SUBSTATION --}}
                            <div class="col-md-4 ">
                                <div class="card p-3">
                                    <div id="substation-container" style="width:100%; height: 400px; margin: 0 auto"   class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- PENDING SUBSTATION --}}
                            <div class="col-md-4 ">
                                <div class="card p-3">
                                    <div id="pending_substation-container" style="width:100%; height: 400px; margin: 0 auto"   class="high-chart" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- SUBSTATION END --}}

            {{-- FEEDER PILLAR START --}}
            <div class="col-md-12">
                <div class="card card-info">

                    <div class="card-header">{{ __('messages.feeder_pillar') }}</div>

                    <div class="card-body">
                        <div class="row">

                            {{-- TOTAL FEEDER PILLAR VISITED --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center">{{ __('messages.total_feeder_pillar_visited') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="feeder_pillar"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL FEEDER PILLAR DEFECTS --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_defects') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="feeder_pillar_defect"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL FEEDER PILLAR PENDING --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_pending') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="feeder_pillar_pending"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL FEEDER PILLAR ACCEPT --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_feeder_pillar_accept') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="feeder_pillar_accept"></span></p>
                                </div>
                            </div>

                            {{-- SURYED FEEDER PILLAR CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_feeder_pillar-container"
                                        style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- FEEDER PILLAR CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="feeder_pillar-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" >
                                    </div>
                                </div>
                            </div>

                            {{-- PENDING FEEDER PILLAR --}}
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
            {{-- FEEDER PILLAR END --}}



            {{-- TIANG START --}}

            <div class="col-md-12">
                <div class="card card-success">

                    <div class="card-header">{{ __('messages.tiang') }}</div>

                    <div class="card-body">
                        <div class="row">

                            {{-- TOTAL TIANG VISITED --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center">{{ __('messages.total_tiang_visited') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="tiang"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL TIANG DEFECTS --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_tiang_defects') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="tiang_defect"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL TIANG PENDING --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_tiang_pending') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="tiang_pending"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL TIANG ACCEPT --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_tiang_accept') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="tiang_accept"></span></p>
                                </div>
                            </div>

                            {{-- SURVEY TIANG CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_tiang-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- TIANG CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="tiang-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- PENDING CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_tiang-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TIANG END --}}



            {{-- LINK BOX START --}}
            <div class="col-md-12">
                <div class="card card-primary">

                    <div class="card-header">{{ __('messages.link_box') }}</div>

                    <div class="card-body">
                        <div class="row">

                            {{-- TOTAL LINK BOX --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_link_box_visited') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="link_box"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL LINK BOX DEFECTS --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_link_box_defects') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="link_box_defect"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL LINK BOX PENDING --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_link_box_pending') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="link_box_pending"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL LINK BOX ACCEPT --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_link_box_accept') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="link_box_accept"></span></p>
                                </div>
                            </div>

                            {{-- SURVYED LINK BOX CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_link_box-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- LINK BOX CHART --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="link_box-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- PENDING LINK BOX --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_link_box-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- LINK BOX END --}}



            {{-- CABLE BRIDGE START --}}
            <div class="col-md-12">
                <div class="card card-danger">

                    <div class="card-header"> {{ __('messages.cable_bridge') }}</div>

                    <div class="card-body">
                        <div class="row">

                            {{-- TOTAL CABLE BRIDGE VISITED --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_visited') }}</h3>
                                    <p class="text-center mb-0 pb-0"><span id="cable_bridge"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL CABLE BRIDGE DEFECTS --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_defects') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="cable_bridge_defect"></span> </p>
                                </div>
                            </div>

                            {{-- TOTAL CABLE BRIDGE PENDING --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_pending') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="cable_bridge_pending"></span></p>
                                </div>
                            </div>

                            {{-- TOTAL CABLE BRIDGE ACCEPT --}}
                            <div class="col-md-3">
                                <div class="card p-3">
                                    <h3 class="text-center"> {{ __('messages.total_cable_bridge_accept') }} </h3>
                                    <p class="text-center mb-0 pb-0"><span id="cable_bridge_accept"></span></p>
                                </div>
                            </div>

                            {{-- SURVYED CABLE BRIDGE --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="suryed_cable_bridge-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- CABLE BRIDGE --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="cable_bridge-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                            {{-- PENDING CABLE BRIDGE --}}
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div id="pending_cable_bridge-container" style="width:100%; height: 400px; margin: 0 auto" class="high-chart" ></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- CABLE BRIDGE END --}}

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
        var from_date = $('#excel_from_date').length > 0 ?$('#excel_from_date').val() : '';
        var to_date = $('#excel_to_date').length > 0 ?  $('#excel_to_date').val(): '';
        var excel_ba = $('#excelBa').val() ?? '';
        var team = '';
        var user = '';

        zoom = 9;

        function addRemoveBundary(param, paramY, paramX)
        {

            var q_cql = "ba ILIKE '%" + param + "%' "
            var user  = $('#user').val();
            var t_cql = q_cql;
            var p_cql = q_cql;

            if (user != '') {
                q_cql = q_cql + " AND created_by='" + user+"' ";
                t_cql = t_cql + " AND created_by='" + user+"' ";
                p_cql = p_cql + " AND created_by='" + user+"' ";
            }

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

        // ZOOM TO MAP
            map.flyTo([parseFloat(paramY), parseFloat(paramX)], zoom, {
                duration: 1.5, // Animation duration in seconds
                easeLinearity: 0.25,
            });


        // PATROLLING
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


        // PANO LAYER
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


        // WORK PACKAGE
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


        // SUBSTATION WITH DEFECTS
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


        // SUBSTATION WITHOUT DEFECTS
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


        // SUBSTATION REJECT
            if (sub_reject != '') { map.removeLayer(sub_reject) }

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

        // SUBSTATION PENDING
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


        // FEEDER PILLAR DEFECTS
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


        // FEEDER PILLAR WITHOUT DEFECTS
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


        // FEEDER PILLAR REJECT
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


        // FEEDER PILLAR PENDING
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

            // if (fp_unsurveyed != '') {
            //     map.removeLayer(fp_unsurveyed)
            // }
            // fp_unsurveyed = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
            //     layers: 'cite:fp_unsurveyed',
            //     format: 'image/png',
            //     cql_filter: "ba ILIKE '%" + param + "%'",
            //     maxZoom: 21,
            //     transparent: true
            // }, {
            //     buffer: 10
            // })

            // map.addLayer(fp_unsurveyed)
            // fp_unsurveyed.bringToFront()

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



        function addGroupOverLays()
        {
            if (layerControl != '') {
                map.removeControl(layerControl);
            }

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
                    // 'Substation Unsurveyed': unservey,

                    'Pano': pano_layer,
                    'Work Package': work_package,

                    'Feeder Pillar Surveyed with defects': fp_with_defects,
                    'Feeder Pillar Surveyed Without defects': fp_without_defects,
                    'Feeder Pillar Pending':fp_pending,
                    'Feeder Pillar Reject':fp_reject,
                    // 'Feeder Pillar Unsurveyed': fp_unsurveyed,

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
            showLoader();
            setTimeout(() => {
                
                getAllStats()
            
        }, 1000);
            // $('#stats_table').DataTable()
           

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
        function onChangeBA(param) 
        {

            // clear all charts
            $('.high-chart').html('');
            showLoader();

            setTimeout(() => {
                if ('{{ Auth::user()->ba }}' == '') {
                getAllStats();
                callLayers(param);
                }
            }, 1000);
           
        }


        function mainBarChart(cat, series, id, tName)
        {
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




        function getDateCounts()
        {


            $.ajax({
                url: `/{{ app()->getLocale() }}/patrol_graph?ba=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data)
                {
                    if (data && data['patrolling'] != '') {
                        makeArray(data['patrolling'], 'patrolling-container', '')
                    }

                    const counts = ['substation' , 'feeder_pillar' , 'link_box' , 'cable_bridge' , 'tiang']

                    for (let index = 0; index < 5; index++)
                    {
                        makeArray(data[counts[index]] , `${counts[index]}-container` , "Defects" );
                        makeArray(data['suryed_'+counts[index]] , `suryed_${counts[index]}-container` , "Visited" );
                        makeArray(data['pending_'+counts[index]] , `pending_${counts[index]}-container` , "Pending" );
                    }
                    getAllCounts()
                },error: function (error) {
                    alert("Request Failed");
                    hideLoader();
                }
            });
        }


        function getAllCounts()
        {


            $.ajax({
                url: `/{{ app()->getLocale() }}/admin-get-all-counts?ba=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data)
                {
                    for (var key in data) {
                        $("#" + key).html(data[key]);
                    }
                    hideLoader()
                },error: function (error) {
                    alert("Request Failed");
                    hideLoader();
                }
            });


        }

        function makeTotalArray(arr, id)
        {
            var cate = arr.map(item => item.ba);
            var seriesD = arr.map(item => item.count);

            var series = [{
                name: 'Count',
                data: seriesD
            }];

            console.log(series);
            mainBarChart(cate, series, id, 'Counts');


        }


        function makeArray(data, id, tName)
        {


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
//         $(document).ajaxStart(function () {
//     showLoader();
// }).ajaxStop(function () {
//     hideLoader();
// });


        function getValues()
        {
            let todaydate = '{{ date('Y-m-d') }}';
            team =$('#team').length > 0 ? $('#team').val() : ''
            user =$('#user').length > 0 ? $('#user').val() : ''

            excel_ba = $('#excelBa').val() ?? '';
            if ($('#excel_from_date').length ==0 || $('#excel_from_date').val() == '') {
                from_date = '1970-01-01'
                console.log('id');
            } else {
                console.log("esle");
                from_date = $('#excel_from_date').val();
            }
            if ($('#excel_to_date').length ==0 || $('#excel_to_date').val() == '') {
                to_date = todaydate
            } else {
                to_date = $('#excel_to_date').val();
            }
        }
        function getAllStats()
        {
            // showLoader();
            getValues()
            $.ajax({
                url: `/{{ app()->getLocale() }}/admin-statsTable?ba_name=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data) {
                    var table = data.data;
                    var table_footer = data.sum;

                    // Destroy existing DataTable instance (if any)

                    if ($.fn.DataTable.isDataTable('#stats_table_1')) {
                        $('#stats_table_1').DataTable().destroy();
                    }

                    var str = '';
                        for (var i = 0; i < table.length; i++)
                        {
                            let total = table[i].ba + '_total';
                            str += `<tr>
                                        <td>${table[i].ba}</td>
                                        <td>${table[i].patroling}</td>
                                        <td>${table[i].substation}</td>
                                        <td>${table[i].feeder_pillar}</td>
                                        <td>${table[i].tiang}</td>
                                        <td>${table[i].link_box}</td>
                                        <td>${table[i].cable_bridge}</td>
                                        <td>${table[i][total]}</td>
                                    </tr>`;
                        }

                    $('#stats_table').html(str);
                    var str2 = '<tr><th>Total</th>';
                        str2 += `<th>${parseFloat(table_footer['patroling']).toFixed(2)}</th>`;
                        str2 += `<th>${table_footer.substation.pending} / ${table_footer.substation.surveyed} </th>`;
                        str2 += `<th>${table_footer.feeder_pillar.pending} / ${table_footer.feeder_pillar.surveyed} </th>`;
                        str2 += `<th>${table_footer.tiang.pending} / ${table_footer.tiang.surveyed} </th>`;
                        str2 += `<th>${table_footer.link_box.pending} / ${table_footer.link_box.surveyed} </th>`;
                        str2 += `<th>${table_footer.cable_bridge.pending} / ${table_footer.cable_bridge.surveyed} </th>`;
                        str2 += `<th>${table_footer.pending} / ${table_footer.total}</th>`;
                        str += '</tr>';

                    $('#stats_table_footer').html(str2);

                    // Reinitialize DataTable with new options
                    $('#stats_table_1').DataTable({
                        searching: false, // Disable search bar
                        paging: false // Disable pagination
                    });
                    getAllStatsByUser();
                },error: function (error) {
                    alert("Request Failed");
                    hideLoader();
                }
            });
        }
        // END GET ALL STATS

        function getAllStatsByUser()
        {

            $.ajax({
                url: `/{{ app()->getLocale() }}/admin-getstats-by-users?ba_name=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data) {
                    var table = data.data;
                    var tableTotal = data.tableTotal;

                    
                    console.log(table);


                    // Destroy existing DataTable instance (if any)

                    if ($.fn.DataTable.isDataTable('#stats-count-by-users')) {
                        $('#stats-count-by-users').DataTable().destroy();
                    }

                    var str = '';
                    var str2 = '';

                    var total = '';
                    
                    for (var i = 0; i < table.length; i++) 
                    {
                        str += `<tr>
                                    <td>${table[i].name}</td>
                                    <td>${table[i].patroling}</td>
                                    <td>${table[i].substation}</td>
                                    <td>${table[i].feeder_pillar}</td>
                                    <td>${table[i].tiang}</td>
                                    <td>${table[i].link_box}</td>
                                    <td>${table[i].cable_bridge}</td>
                                    <td>${ table[i].total}</td>
                                </tr>`;
                                 
                    }
                    $('#stats-count-by-users-body').html(str);
                    str2 += `<tr>
                        <th>Total</th>
                        <th>${parseFloat(tableTotal['patroling']).toFixed(2)}</th>
                        <th>${tableTotal['substation_accept']} / ${tableTotal['substation']}</th>
                        <th>${tableTotal['feeder_pillar_accept']} / ${tableTotal['feeder_pillar']}</th>
                        <th>${tableTotal['tiang_accept']} / ${tableTotal['tiang']}</th>
                        <th>${tableTotal['link_box_accept']} / ${tableTotal['link_box']}</th>
                        <th>${tableTotal['cable_bridge_accept']} / ${tableTotal['cable_bridge']}</th>
                        <th>${tableTotal['substation_accept'] + tableTotal['feeder_pillar_accept'] + tableTotal['tiang_accept'] + tableTotal['link_box_accept'] + tableTotal['substation_accept']+ tableTotal['cable_bridge_accept']}
                            / ${ tableTotal.substation + tableTotal.feeder_pillar +tableTotal.tiang + tableTotal.link_box +tableTotal.cable_bridge}</th>
                    </tr>`;

                    $('#stats-count-by-users-footer').html(str2);

                    

                    // Reinitialize DataTable with new options
                    $('#stats-count-by-users').DataTable({
                        "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                    ]});

                    getDateCounts();
                }, error: function (error) {
                    alert("Request Failed");
                    hideLoader();
                }
            })

        }


        function resetDashboard()
        {
            if ("{{Auth::user()->ba}}" == '') {
                $('#excelBa').empty();
                $('#zone').val('');

            }
            
            $('#excel_from_date, #excel_to_date , #team , #user').val('');
            onChangeBA();
            from_date = '';
            to_date = '';

            if (ba == '') {
                addRemoveBundary('', 2.75101756479656, 101.304931640625)
            } else {
                callLayers(ba);
            }
        }


        setTimeout(() => {
            // getDateCounts();
        }, 1000);


        function onChangeTeam(team)
        {
            var cu_ba = $('#excelBa').val() ?? 'null';

            $.ajax({
                url: `/{{ app()->getLocale() }}/get-users-by-team?team=${team}&ba_name=${cu_ba}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(response)
                {
                    var data = response.data
                    console.log(data);
                    $('#user').find('option').remove();
                    $('#user').append(`<option value="" hidden>select user</option>`)
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        $('#user').append(`<option value="${element.name}">${element.name}</option>`)


                    }
                    onChangeBA()
                }
            })

        }

        function showLoader() {
    document.getElementById('overlay2').style.display = 'block';
    document.getElementById('loader').style.display = 'block';
}

function hideLoader() {
    document.getElementById('overlay2').style.display = 'none';
    document.getElementById('loader').style.display = 'none';
}
    </script>

    {{-- COUNTS END --}}
@endsection
