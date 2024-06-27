@extends('layouts.map_layout')
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




    </style>
@endsection
@section('content')



@include('layouts.shared.nav-bar')




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


                    <div class=" col-md-2 form-input px-2">
                        <label for="search_by">Search By : </label>
                        <select name="search_by" id="search_by" class="form-control">
                            <option value="created_by">created by</option>
                            <option value="updated_by">updated by</option>
                        </select>
                    </div>


                    <div class=" col-md-2 form-input px-2">
                        <label for="search_by">Cycle : </label>
                        <select name="cycle" id="cycle" class="form-control">
                            <option value="">All</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>


                    <div class="col-md-2 pt-2">
                        <br>
                        <button class="btn btn-secondary  " type="button" onclick="filterByDate()">Filter</button>
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
                        <div class="text-end">
                        <button class="btn btn-sm btn-secondary mb-3" type="button" onclick="previewUsersCountPdf()">Preview PDF</button>
                        </div>
                        {{-- <button type="button" onclick="exportToPDF()">Download</button> --}}
                        <div class="table-responsive  " id="stats-count-by-users-div" style="max-height:100vh;">
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


        </div>

        @endif



@endsection


@section('script')




    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    @include('partials.map-js')



    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> --}}

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>




    <script>

        var patroling = '';
        var patrol = [];
        var from_date = $('#excel_from_date').length > 0 ?$('#excel_from_date').val() : '';
        var to_date = $('#excel_to_date').length > 0 ?  $('#excel_to_date').val(): '';
        var excel_ba = $('#excelBa').val() ?? '';
        var team = '';
        var user = '';
        var searchBy = $('#search_by').val();
        var cycles='';

        zoom = 9;




        $(function() {
            showLoader();

            setTimeout(() => {
                getValues()
            }, 1000);
        })



        function filterByDate()
        {
            var ff_ba = $('#excelBa').val() ?? '';
            from_date = $('#excel_from_date').val() ?? null;
            to_date = $('#excel_to_date').val() ?? null;
            onChangeBA();
        }


        function onChangeBA(param) {

            showLoader();

            setTimeout(() => {

                getValues()

            }, 1000);
        }



    </script>



    {{-- COUNTS START --}}

    <script>


        function getValues()
        {
            let todaydate = '{{ date('Y-m-d') }}';
            team =$('#team').length > 0 ? $('#team').val() : ''
            user =$('#user').length > 0 ? $('#user').val() : ''
            searchBy = $('#search_by').val();
            cycles = $('#cycle').val();


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
            getAllStats()
            getAllStatsByUser()

        }







        function getAllStats()
        {

            $.ajax({
                url: `/{{ app()->getLocale() }}/admin-statsTable?ba_name=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}&searchBy=${searchBy}&cycle=${cycles}`,
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
                url: `/{{ app()->getLocale() }}/admin-getstats-by-users?ba_name=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}&searchBy=${searchBy}&cycle=${cycles}`,
                dataType: 'JSON',
                method: 'GET',
                async: false,
                success: function callback(data) {
                    var table = data.data;
                    var tableTotal = data.tableTotal;

                    // Destroy existing DataTable instance (if any)

                    if ($.fn.DataTable.isDataTable('#stats-count-by-users')) {
                        $('#stats-count-by-users').DataTable().destroy();
                    }

                    var str = '';
                    var str2 = '';

                    var total = '';

                    for (var i = 0; i < table.length; i++)
                    {
                        // if (table[i].total !== '0/0' || table[i].patroling !== 0 && table[i].patroling !== null)
                        // {

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
                        // }

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
                        <th>${tableTotal['substation_accept'] + tableTotal['feeder_pillar_accept'] + tableTotal['tiang_accept'] + tableTotal['link_box_accept'] + tableTotal['cable_bridge_accept']}
                            / ${ tableTotal.substation + tableTotal.feeder_pillar +tableTotal.tiang + tableTotal.link_box +tableTotal.cable_bridge}</th>
                    </tr>`;

                    $('#stats-count-by-users-footer').html(str2);


                    // Reinitialize DataTable with new options
                    $('#stats-count-by-users').DataTable({
                        "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                    ]});
                    hideLoader()

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

        }





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





        function previewUsersCountPdf() {

            var url = `/{{ app()->getLocale() }}/admin-getstats-by-users?ba_name=${excel_ba}&from_date=${from_date}&to_date=${to_date}&user=${user}&team=${team}`;
            var a = document.createElement('a');
            a.href = url;
            a.target = '_blank';
            a.click();
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
