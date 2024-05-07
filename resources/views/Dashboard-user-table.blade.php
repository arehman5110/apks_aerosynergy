@extends('layouts.map_layout', ['page_title' => 'Index'])

@section('css')
    @include('partials.map-css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection




@section('content')
    <div class="container">
        <div class="">
            <div class="text-end">
                <button onclick="convertToCanvas()" class="btn btn-secondary">Download PDF</button>
            </div>
            <div class="table-responsive- " id="stats-count-by-users-div">
                <table class="table table-bordered">
                    <tr>
                        <th>BA</th>
                        <th>FROM DATE</th>
                        <th>TO DATE</th>
                        <th>TEAM</th>
                    </tr>
                    <tr>
                        <td>{{ $requestData->ba_name != '' ? $requestData->ba_name : 'ALL' }}</td>
                        <td>{{ $requestData->from_date }}</td>
                        <td>{{ $requestData->to_date }}</td>
                        <td>{{ $requestData->team != '' ? $requestData->team : 'ALL' }}</td>

                    </tr>
                </table>
                <table class="table table-bordered" id="stats-count-by-users">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th scope="col">User</th>
                            <th scope="col">Patroling(KM)</th>
                            <th scope="col">Substation</th>
                            <th scope="col">Feeder Pillar</th>
                            <th scope="col">Tiang</th>
                            <th scope="col">Link Box</th>
                            <th scope="col">Cable Bridge</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody id='stats-count-by-users-body'>

                        @foreach ($data as $count)
                            {{-- @if ($count['total'] !== '0/0' || $count['patroling'] !== 0 && $count['patroling'] !== null) --}}
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{ $count['name'] }}</td>
                                    <td>{{ $count['patroling'] }}</td>
                                    <td>{{ $count['substation'] }}</td>
                                    <td>{{ $count['feeder_pillar'] }}</td>
                                    <td>{{ $count['tiang'] }}</td>
                                    <td>{{ $count['link_box'] }}</td>
                                    <td>{{ $count['cable_bridge'] }}</td>
                                    <td>{{ $count['total'] }}</td>
                                </tr>
                            {{-- @endif --}}

                        @endforeach
                    </tbody>
                    <tfoot id='stats-count-by-users-footer'>
                        <tr>
                            <th>{{sizeof($data)}}</th>
                            <th>Total</th>
                            <th>{{ $tableTotal['patroling'] }}</th>
                            <th>{{ $tableTotal['substation_accept'] }} / {{ $tableTotal['substation'] }}</th>
                            <th>{{ $tableTotal['feeder_pillar_accept'] }} / {{ $tableTotal['feeder_pillar'] }}</th>
                            <th>{{ $tableTotal['tiang_accept'] }} / {{ $tableTotal['tiang'] }}</th>
                            <th>{{ $tableTotal['link_box_accept'] }} / {{ $tableTotal['link_box'] }}</th>
                            <th>{{ $tableTotal['cable_bridge_accept'] }} / {{ $tableTotal['cable_bridge'] }}</th>
                            <th>{{ $tableTotal['substation_accept'] + $tableTotal['feeder_pillar_accept'] + $tableTotal['tiang_accept'] + $tableTotal['link_box_accept'] + $tableTotal['cable_bridge_accept'] }}
                                /
                                {{ $tableTotal['substation'] + $tableTotal['feeder_pillar'] + $tableTotal['tiang'] + $tableTotal['link_box'] + $tableTotal['cable_bridge'] }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        var from_date = "{{ $requestData->from_date }}"
        var to_date = "{{ $requestData->to_date }}"
        var team = "{{ $requestData->team }}"
        var ba = "{{ $requestData->ba_name }}"


        $(function() {
            window.jsPDF = window.jspdf.jsPDF;

        })


        function convertToCanvas() {
            showLoader()
            let jsPdf = new jsPDF('p', 'pt', 'letter');
            var htmlElement = document.getElementById('stats-count-by-users-div');
            var pdfName = `Users counts BA_${ba} ( ${from_date} - ${to_date} ) TEAM_${team}.pdf`;
            const opt = {
                callback: function(jsPdf) {
                    jsPdf.save(pdfName);
                    hideLoader()
                },
                margin: [30, 30, 30, 30],
                autoPaging: true, // Enable auto paging
                html2canvas: {
                    allowTaint: true,
                    dpi: 300,
                    letterRendering: true,
                    logging: false,
                    scale: 0.5
                }
            };

            jsPdf.html(htmlElement, opt);
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
@endsection
