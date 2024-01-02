<style>
    .row{
        border: 0px;
    }
    .body{background: #00B4DB;background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);background: linear-gradient(to right, #0083B0, #00B4DB);color: #514B64;min-height: 100vh}
    .choices[data-type*=select-multiple] .choices__inner, .choices[data-type*=text] .choices__inner {
    background: white;
    box-shadow: 0 0 24px rgba(91, 94, 222, 0.1)}


.choices__input {
    border: 0px !important; margin-bottom: 0px !important}

</style>

<div class="col-12">
    <div class="collapse" id="collapseQr">
        <div class="card card-body">
            <form action="{{ isset($url) ? route($url, app()->getLocale()) : '#' }}"
                onsubmit="collapseFilter()" method="post">
                @csrf
                <div class="row form-input ">
                    <div class=" col-md-2">
                        <label for="excelZone">Zone :</label>
                        <select name="excelZone" id="excelZone" class="form-control" onchange="getBa(this.value)">
                            <option value="{{ Auth::user()->zone }}" hidden>
                                {{ Auth::user()->zone != '' ? Auth::user()->zone : 'Select Zone' }}
                            </option>
                            @if (Auth::user()->zone == '')
                                <option value="W1">W1</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="B4">B4</option>
                            @endif
                        </select>
                    </div>
                    <div class=" col-md-2">
                        <label for="excelBa">BA :</label>
                        <select name="ba" id="excelBa" class="form-control">
                            <option value="{{ Auth::user()->ba }}" hidden>
                                {{ Auth::user()->ba != '' ? Auth::user()->ba : 'Select BA' }} </option>

                        </select>
                    </div>

                     {{-- @if (Auth::user()->ba != '' && $url !='generate-third-party-digging-excel') --}}
                    <div class=" col-md-2">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="" >All</option>
                            <option value="unsurveyed">Unurveyed</option>
                            <option value="surveyed_with_defects">Surveyed with defects</option>
                            <option value="surveyed_without_defects">Surveyed without defects</option>

                        </select>
                    </div>


                    <div class=" col-md-2">
                        <label for="qa_status">QA Status</label>
                        <select name="qa_status" id="qa_status" class="form-control">
                            <option value="" >All</option>
                            <option value="Accept">Accept</option>
                            <option value="Reject">Reject</option>
                            <option value="pending">Pending</option>

                        </select>
                    </div>
                    {{-- @endif --}}


                    <div class=" col-md-2">
                        <label for="excel_from_date">From Date : </label>
                        <input type="date" name="from_date" id="excel_from_date"
                            class="form-control" onchange="setMinDate(this.value,'{{explode('-',$url)[1]}}')">
                    </div>
                    <div class=" col-md-2">
                        <label for="excel_to_date">To Date : </label>
                        <input type="date" name="to_date" id="excel_to_date" onchange="setMaxDate(this.value,'{{explode('-',$url)[1]}}')" class="form-control">
                    </div>
                    @isset($url)
                    <div class="col-md-1 pt-2 ">

                        <button type="button" class="btn text-white btn-sm mt-4 " class="form-control"
                            style="background-color: #708090" onclick="resetIndex()">Reset</button>
                    </div>

                    <div class="col-md-2 pt-2 ">

                        <button type="submit" class="btn text-white btn-sm mt-4 " class="form-control"
                            style="background-color: #708090">Download QR </button>
                    </div>
                    @endisset







            </form>
        </div>


            @if ($url == 'generate-substation-excel')

            <div class="row">
            <div class="row d-flex justify-content- mt-100 px-4" >
                <label for="excelZone">Filter Defects :</label>
                <div class="col-md-12"> <select id="choices-multiple-remove-button" class="form-control" placeholder="Select tags" multiple>
                        <option value="grass">grass</option>
                        <option value="treebranches">tree_branches_status</option>
                        <option value="gate_loc">gate_loc</option>
                        <option value="gate_demage">gate_demage</option>
                        <option value="gate_other">gate_other</option>
                        <option value="broken_gutter">broken_gutter</option>
                        <option value="broken_roof">broken_roof</option>
                        <option value="broken_base">broken_base</option>
                        <option value="building_other">building_others</option>
                        <option value="poster_status">poster_status</option>
                    </select>
                </div>
                <p>
                    <button type="button" class="btn text-white btn-sm mt-4 "  onclick="filter_data_withDefects()" class="form-control"
                        style="background-color: #708090">Filter </button>
                    </p>
            </div>
        </div>

                @endif

    </div>
</div>
