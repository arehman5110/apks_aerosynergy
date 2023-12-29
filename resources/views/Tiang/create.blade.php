@extends('layouts.app')

@section('css')
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700" rel="stylesheet" />


    <link rel="stylesheet" href="{{ URL::asset('assets/test/css/style.css') }}" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- @include('partials.map-css') --}}
    <style>
        input[type='radio'] {
            border-radius: 50% !important;
        }

        .fw-400 {
            font-weight: 400 !important;
        }

        input[type='checkbox'],
        input[type='radio'] {
            min-width: 16px !important;
            margin-right: 12px;
        }

        input[type='file'],
        table input {
            margin: 0px !important;
        }

        table label {
            font-size: 14px !important;
            font-weight: 400 !important;
            margin-left: 10px !important;
            margin-bottom: 0px !important
        }

        th {
            font-size: 14px !important;
        }

        th,
        td {
            padding: 6px 16px !important
        }

        table,
        input[type='file'] {
            width: 90% !important;
        }

        #map {
            margin: 30px;
            height: 400px;
            padding: 20px;
        }

        table input[type="file"] {
            font-size: 11px !important;
            height: 33px !important;
        }

        td.d-flex {
            border-bottom: 0px !important;
            border-left: 0px !important;
            border-right: 0px !important;
        }

        .defects input[type="file"] {
            margin-bottom: 5px !important;
        }

        textarea {
            border: 1px solid #999999 !important;
        }

        .form-input .card {
            /* border: 1px solid black !important; */
            border-radius: 0px !important
        }

        span.number {
            display: none
        }
    </style>
@endsection


@section('content')
    <section class="content-header ">
        <div class="container-  ">
            <div class="row  " style="flex-wrap:nowrap">
                <div class="col-sm-6">
                    <h3>{{ __('messages.tiang') }}</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('tiang-talian-vt-and-vr.index', app()->getLocale()) }}">{{ __('messages.index') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('messages.create') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class=" ">

        <div class="container ms-auto">

            <div class=" ">

                <div class=" card col-md-12 p-3 ">
                    <div class=" ">
                        <h3 class="text-center p-2">{{ __('messages.qr_savr') }}</h3>
                        <form id="framework-wizard-form"
                            action="{{ route('tiang-talian-vt-and-vr.store', app()->getLocale()) }}"
                            enctype="multipart/form-data" style="display: none" method="POST"
                            onsubmit="return submitFoam()">
                            @csrf
                            <h3>{{ __('messages.info') }}</h3>


                            {{-- START Info (1) --}}
                            <fieldset class=" form-input">

                                <div class="row">
                                    <div class="col-md-4"><label for="ba">{{ __('messages.ba') }}</label></div>
                                    <div class="col-md-4"><select name="ba_s" id="ba_s" class="form-control"
                                            onchange="getWp(this)" required>
                                            @if (Auth::user()->ba == '')
                                                <option value="" hidden>Select ba</option>
                                                <optgroup label="W1">
                                                    <option
                                                        value="KL PUSAT,KUALA LUMPUR PUSAT, 3.14925905877391, 101.754098819705">
                                                        KL PUSAT</option>
                                                </optgroup>
                                                <optgroup label="B1">
                                                    <option value="PJ,PETALING JAYA, 3.1128074178475, 101.605270457169">
                                                        PETALING JAYA</option>
                                                    <option value="RAWANG,RAWANG, 3.47839445121726, 101.622905486475">RAWANG
                                                    </option>
                                                    <option
                                                        value="K.SELANGOR,KUALA SELANGOR, 3.40703209426401, 101.317426926947">
                                                        KUALA SELANGOR</option>
                                                </optgroup>
                                                <optgroup label="B2">
                                                    <option value="KLANG,KLANG, 3.08428642705789, 101.436185279023">KLANG
                                                    </option>
                                                    <option
                                                        value="PORT KLANG,PELABUHAN KLANG, 2.98188527916042, 101.324234779569">
                                                        PELABUHAN KLANG</option>
                                                </optgroup>
                                                <optgroup label="B4">
                                                    <option value="CHERAS,CHERAS, 3.14197346621987, 101.849883983416">CHERAS
                                                    </option>
                                                    <option
                                                        value="BANTING/SEPANG,BANTING, 2.82111390453244, 101.505890775541">
                                                        BANTING</option>
                                                    <option value="BANGI,BANGI,2.965810949933260,101.81881303103104">BANGI
                                                    </option>
                                                    <option
                                                        value="PUTRAJAYA/CYBERJAYA/PUCHONG,PUTRAJAYA & CYBERJAYA, 2.92875032271019, 101.675338316575">
                                                        PUTRAJAYA & CYBERJAYA</option>
                                                </optgroup>
                                            @else
                                            @endif

                                        </select>
                                        <input type="hidden" name="ba" id="ba">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4"><label for="fp_name"> {{ __('messages.name_of_substation') }} /
                                            {{ __('messages.Name_of_Feeder_Pillar') }} </label></div>
                                    <div class="col-md-4"><input type="text" name="fp_name" id="fp_name"
                                            class="form-control" required></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"><input type="text" name="fp_name" id="fp_name"
                                            class="form-control" required></div>
                                </div>



                               

                                <div class="row">
                                    <div class="col-md-4"><label for="">{{ __('messages.Section') }} </label></div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="section_from">{{ __('messages.from') }} </label>
                                    </div>
                                    <div class="col-md-4"><input type="text" name="section_from" id="section_from"
                                            class="form-control"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="section_to">{{ __('messages.to') }}</label></div>
                                    <div class="col-md-4"><input type="text" name="section_to" id="section_to"
                                            class="form-control"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="tiang_no">{{ __('messages.Tiang_No') }}</label>
                                    </div>
                                    <div class="col-md-4"><input type="text" name="tiang_no" id="tiang_no"
                                            class="form-control" required></div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="review_date">{{__('messages.visit_date')}}</label>
                                    </div>
                                    <div class="col-md-4"><input type="date" name="review_date" id="review_date"
                                            class="form-control" required></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="main_line">{{__('messages.main_line_service_line')}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="talian_utama" id="main_line" class="form-control"  onchange="getMainLine(this.value)">
                                            <option value="" hidden>select</option>
                                            <option value="main_line">Main Line</option>
                                            <option value="service_line">Service Line</option>
                                        </select>
                                </div>
                                </div>
                                <div class="row d-none" >
                                    <div class="col-md-4">
                                        <label for="">
                                            Number of Services Involves 1 user only

                                        </label>
                                    </div>
                                    <div class="col-md-2 d-flex mt-2">
                                        <input type="number" name="talian_utama_connection" class="form-control"  id="main_line_connection_one"
                                              >
                                          
                                              





                                       

                                            </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4"><label for="pole_image-1">{{ __('messages.pole') }} Image 1
                                        </label>
                                    </div>
                                    <div class="col-md-5 p-2 pr-5"><input type="file" name="pole_image_1"
                                            id="pole_image_1" required accept="image/*" class="form-control">
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label for="pole_image-2">{{ __('messages.pole') }} Image
                                            2</label>
                                    </div>
                                    <div class="col-md-5 p-2 pr-5"><input type="file" name="pole_image_2"
                                            id="pole_image_2" required accept="image/*" class="form-control">
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-md-4"><label for="cordinates">{{ __('messages.coordinate') }}</label>
                                    </div>
                                    <div class="col-md-4"><input type="text" name="cordinates" id="cordinates"
                                            class="form-control" required readonly></div>
                                </div>

                                <input type="hidden" name="lat" id="lat" required class="form-control">
                                <input type="hidden" name="log" id="log" class="form-control">

                                <div class="text-center">
                                    <strong> <span class="text-danger map-error"></span></strong>
                                </div>

                                <div id="map">

                                </div>


                            </fieldset>
                            {{-- END Info (1) --}}
                            <h3> {{ __('messages.Asset_Register') }} </h3>


                            {{-- START Asset Register (2) --}}
                            <fieldset class="form-input">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="card p-4">
                                            <label for="st7">
                                                {{ __('messages.Pole_Size_Bill') }} </label>
                                            <div class="row">

                                                <div class=" col-md-12 row">




                                                    <div class="d-flex col-md-4">
                                                        <input type="radio" name="size_tiang" value="7.5"
                                                            id="st7" class="  ">
                                                        <label for="st7" class="fw-400"> 7.5</label>

                                                    </div>

                                                    <div class="d-flex col-md-4">
                                                        <input type="radio" name="size_tiang" value="9"
                                                            id="st9" class=" ">
                                                        <label for="st9" class="fw-400"> 9</label>

                                                    </div>

                                                    <div class="d-flex col-md-4">
                                                        <input type="radio" name="size_tiang" value="10"
                                                            id="st10" class=" ">
                                                        <label for="st10" class="fw-400"> 10</label>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card p-4">

                                            <label for="">{{ __('messages.Pole_type_No') }} </label>
                                            <div class="row">

                                                <div class="col-md-12  row ">


                                                    <div class="d-flex col-md-4">

                                                        <input type="radio" name="jenis_tiang" value="spun"
                                                            id="spun" class=" ">
                                                        <label for="spun"
                                                            class="fw-400">{{ __('messages.Spun') }}</label>

                                                    </div>

                                                    <div class="d-flex col-md-4">

                                                        <input type="radio" name="jenis_tiang" value="concrete"
                                                            id="concrete" class=" ">
                                                        <label for="concrete"
                                                            class="fw-400">{{ __('messages.Concrete') }}</label>

                                                    </div>


                                                    <div class="d-flex col-md-4">

                                                        <input type="radio" name="jenis_tiang" value="iron"
                                                            id="iron" class=" ">
                                                        <label for="iron"
                                                            class="fw-400">{{ __('messages.Iron') }}</label>

                                                    </div>

                                                    <div class="d-flex col-md-4">

                                                        <input type="radio" name="jenis_tiang" value="wood"
                                                            id="wood" class=" ">
                                                        <label for="wood"
                                                            class="fw-400">{{ __('messages.Wood') }}</label>

                                                    </div>
                                                </div>

                                            </div>



                                        </div>
                                    </div>


                                        {{-- ABC (Span) 3 X 185 --}}
                                        <div class="col-md-6">
                                            <div class="card p-4">

                                                <label for="section_to">{{ __('messages.ABC_Span') }} 3 X 185</label>
                                                    {!! tiangSpanRadio( '', 'abc_span', 's3_185',  true) !!}

                                                <label for="s3_95">{{ __('messages.ABC_Span') }}3 X 95</label>
                                                    {!! tiangSpanRadio(  '', 'abc_span', 's3_95',  true) !!}

                                                <label for="s3_16">{{ __('messages.ABC_Span') }}3 X 16</label>
                                                    {!! tiangSpanRadio('', 'abc_span', 's3_16',  true) !!}

                                                 <label for="s1_16">{{ __('messages.ABC_Span') }}1 X 16</label>
                                                    {!! tiangSpanRadio('', 'abc_span', 's1_16',  true) !!}

                                            </div>
                                        </div>



                                       {{-- PVC (Span) 19/064 --}}
                                       <div class="col-md-6 ">
                                        <div class="card p-4">
                                                    <label for="s19_064">{{ __('messages.PVC_Span') }}
                                                        19/064</label>

                                                        {!! tiangSpanRadio(     '', 'pvc_span', 's19_064',  true) !!}


                                             <label for="s7_083"  >{{ __('messages.PVC_Span') }}
                                                        7/083</label>
                                                        {!! tiangSpanRadio('', 'pvc_span', 's7_083',  true) !!}



                                                    <label for="s7_044"  >{{ __('messages.PVC_Span') }}
                                                        7/044</label>


                                                        {!! tiangSpanRadio(  '', 'pvc_span', 's7_044',  true) !!}

                                        </div>
                                    </div>

                                        {{-- BARE (Span) 7/173 --}}

                                    <div class="col-md-6 ">
                                        <div class="card p-4">

                                            <label for="s7_173"  >{{ __('messages.BARE_Span') }} 7/173</label>
                                                {!! tiangSpanRadio(  '', 'bare_span', 's7_173',  true) !!}

                                            <label for="s7_122">{{ __('messages.BARE_Span') }} 7/122</label>
                                                {!! tiangSpanRadio( '', 'bare_span', 's7_122',  true) !!}

                                            <label for="s3_132">{{ __('messages.BARE_Span') }} 3/132</label>
                                                {!! tiangSpanRadio( '', 'bare_span', 's3_132',  true) !!}

                                        </div>
                                    </div>







                                </div>






                            </fieldset>

                            {{-- END Asset Register (2) --}}

                            {{-- START Kejanggalan (3) --}}
                            <h3>{{ __('messages.kejanggalan') }}</h3>

                            <fieldset class="form-input defects">
                                <h3>{{ __('messages.kejanggalan') }}</h3>

                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead style="background-color: #E4E3E3 !important">
                                            <th class="col-4">{{ __('messages.title') }}</th>
                                            <th class="col-4">{{ __('messages.defects') }}</th>
                                            <th class="col-4">{{ __('messages.images') }}</th>
                                        </thead>
                                        {{-- POLE --}}
                                        <tr>
                                            <th rowspan="5">{{ __('messages.pole') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[cracked]" id="cracked"
                                                    class="form-check">
                                                <label for="cracked"> {{ __('messages.cracked') }}</label>

                                            </td>
                                            <td>
                                                <input type="file" name="tiang_defect_image[cracked]"
                                                    id="cracked-image" accept="image/*" class="d-none form-control">
                                                <input type="file" name="tiang_defect_image[cracked_2]"
                                                    id="cracked-image-2" accept="image/*" class="d-none form-control">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[leaning]" id="leaning"
                                                    class="form-check">
                                                <label for="leaning"> {{ __('messages.leaning') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="tiang_defect_image[leaning]"
                                                    id="leaning-image" accept="image/*" class="d-none form-control">
                                                <input type="file" name="tiang_defect_image[leaning_2]"
                                                    id="leaning-image-2" accept="image/*" class="d-none form-control">

                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[dim]" id="dim"
                                                    class="form-check">
                                                <label for="dim"> {{ __('messages.no_dim_post_none') }}</label>

                                            </td>
                                            <td>
                                                <input type="file" name="tiang_defect_image[dim]" id="dim-image"
                                                    accept="image/*" class="d-none form-control">
                                                <input type="file" name="tiang_defect_image[dim_2]" id="dim-image-2"
                                                    accept="image/*" class="d-none form-control">

                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="tiang_defect[creepers]" id="creepers"
                                                    class="form-check">
                                                <label for="creepers"> {{ __('messages.Creepers') }} </label>

                                            </td>
                                            <td>
                                                <input type="file" name="tiang_defect_image[creepers]"
                                                    id="creepers-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="tiang_defect_image[creepers_2]"
                                                    id="creepers-image-2" class="d-none form-control" accept="image/*">

                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="tiang_defect[other]" id="other_tiang_defect"
                                                    class="form-check">
                                                <label for="other_tiang_defect"> {{ __('messages.others') }} </label>
                                                <input type="text" name="tiang_defect[other_input]"
                                                    id="other_tiang_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="tiang_defect_image[other]"
                                                    id="other_tiang_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="tiang_defect_image[other_2]"
                                                    id="other_tiang_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Line (Main / Service) --}}

                                        <tr>
                                            <th rowspan="4">{{ __('messages.line_main_service') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="talian_defect[joint]" id="joint"
                                                    class="form-check">
                                                <label for="joint"> {{ __('messages.joint') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="talian_defect_image[joint]" id="joint-image"
                                                    class="d-none  form-control" accept="image/*">
                                                <input type="file" name="talian_defect_image[joint_2]"
                                                    id="joint-image-2" class="d-none  form-control" accept="image/*">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="talian_defect[need_rentis]" id="need_rentis"
                                                    class="form-check">
                                                <label for="need_rentis"> {{ __('messages.need_rentis') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="talian_defect_image[need_rentis]"
                                                    id="need_rentis-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="talian_defect_image[need_rentis_2]"
                                                    id="need_rentis-image-2" class="d-none form-control"
                                                    accept="image/*">


                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="talian_defect[ground]" id="ground"
                                                    class="form-check">
                                                <label
                                                    for="ground">{{ __('messages.Does_Not_Comply_With_Ground_Clearance') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="talian_defect_image[ground]"
                                                    id="ground-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="talian_defect_image[ground_2]"
                                                    id="ground-image-2" class="d-none form-control" accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="talian_defect[other]"
                                                    id="other_talian_defect" class="form-check">
                                                <label for="other_talian_defect"> {{ __('messages.others') }} </label>
                                                <input type="text" name="talian_defect[other_input]"
                                                    id="other_talian_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="talian_defect_image[other]"
                                                    id="other_talian_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="talian_defect_image[other_2]"
                                                    id="other_talian_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>


                                        {{-- Umbang --}}

                                        <tr>
                                            <th rowspan="5">{{ __('messages.Umbang') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[breaking]"
                                                    id="umbang_breaking" class="form-check ">
                                                <label for="umbang_breaking">
                                                    {{ __('messages.Sagging_Breaking') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[breaking]"
                                                    id="umbang_breaking-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="umbang_defect_image[breaking_2]"
                                                    id="umbang_breaking-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[creepers]"
                                                    id="umbang_creepers" class="form-check ">
                                                <label for="umbang_creepers">{{ __('messages.Creepers') }}
                                                    Creepers</label>
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[creepers]"
                                                    id="umbang_creepers-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="umbang_defect_image[creepers_2]"
                                                    id="umbang_creepers-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[cracked]" id="umbang_cracked"
                                                    class="form-check ">
                                                <label for="umbang_cracked">
                                                    {{ __('messages.No_Stay_Insulator_Damaged') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[cracked]"
                                                    id="umbang_cracked-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="umbang_defect_image[cracked_2]"
                                                    id="umbang_cracked-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="umbang_defect[stay_palte]" id="stay_palte"
                                                    class="form-check">
                                                <label
                                                    for="stay_palte">{{ __('messages.Stay_Plate_Base_Stay_Blocked') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[stay_palte]"
                                                    id="stay_palte-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="umbang_defect_image[stay_palte_2]"
                                                    id="stay_palte-image-2" class="d-none form-control" accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="umbang_defect[other]"
                                                    id="other_umbang_defect" class="form-check">
                                                <label for="other_umbang_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="umbang_defect[other_input]"
                                                    id="other_umbang_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="umbang_defect_image[other]"
                                                    id="other_umbang_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="umbang_defect_image[other_2]"
                                                    id="other_umbang_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>


                                        {{-- IPC --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.IPC') }}</th>
                                            <td>
                                                <input type="checkbox" name="ipc_defect[burn]"
                                                    id="ipc_burn"class="form-check">
                                                <label for="ipc_burn">{{ __('messages.Burn Effect') }} Burn Effect</label>
                                            </td>
                                            <td>
                                                <input type="file" name="ipc_defect_image[burn]" id="ipc_burn-image"
                                                    class="d-none form-control" accept="image/*">
                                                <input type="file" name="ipc_defect_image[burn_2]"
                                                    id="ipc_burn-image-2" class="d-none form-control" accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="ipc_defect[other]" id="other_ipc_defect"
                                                    class="form-check">
                                                <label for="other_ipc_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="ipc_defect[other_input]"
                                                    id="other_ipc_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="ipc_defect_image[other]"
                                                    id="other_ipc_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="ipc_defect_image[other_2]"
                                                    id="other_ipc_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Black Box --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.Black_Box') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="blackbox_defect[cracked]"
                                                    id="black_box_cracked" class="form-check">
                                                <label for="black_box_cracked">{{ __('messages.Kesan_Bakar') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="blackbox_defect_image[cracked]"
                                                    id="black_box_cracked-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="blackbox_defect_image[cracked_2]"
                                                    id="black_box_cracked-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="blackbox_defect[other]"
                                                    id="other_blackbox_defect" class="form-check">
                                                <label for="other_blackbox_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="blackbox_defect[other_input]"
                                                    id="other_blackbox_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="blackbox_defect_image[other]"
                                                    id="other_blackbox_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="blackbox_defect_image[other_2]"
                                                    id="other_blackbox_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Jumper --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.jumper') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="jumper[sleeve]" id="jumper_sleeve"
                                                    class="form-check">
                                                <label for="jumper_sleeve">{{ __('messages.no_uv_sleeve') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="jumper_image[sleeve]"
                                                    id="jumper_sleeve-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="jumper_image[sleeve_2]"
                                                    id="jumper_sleeve-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="jumper[burn]" id="jumper_burn"
                                                    class="form-check">
                                                <label for="jumper_burn">{{ __('messages.Burn Effect') }} </label>
                                            </td>
                                            <td>
                                                <input type="file" name="jumper_image[burn]" id="jumper_burn-image"
                                                    class="d-none form-control" accept="image/*">
                                                <input type="file" name="jumper_image[burn_2]"
                                                    id="jumper_burn-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <input type="checkbox" name="jumper[other]" id="other_jumper"
                                                    class="form-check">
                                                <label for="other_jumper">{{ __('messages.others') }}</label>
                                                <input type="text" name="jumper[other_input]" id="other_jumper-input"
                                                    placeholder="mention other defect" required
                                                    class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="jumper_image[other]" id="other_jumper-image"
                                                    class="d-none form-control" accept="image/*">
                                                <input type="file" name="jumper_image[other_2]"
                                                    id="other_jumper-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Lightning catcher --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.lightning_catcher') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="kilat_defect[broken]" id="lightning_broken"
                                                    class="form-check">
                                                <label for="lightning_broken">{{ __('messages.broken') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="kilat_defect_image[broken]"
                                                    id="lightning_broken-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="kilat_defect_image[broken_2]"
                                                    id="lightning_broken-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="kilat_defect[other]" id="other_kilat_defect"
                                                    class="form-check">
                                                <label for="other_kilat_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="kilat_defect[other_input]"
                                                    id="other_kilat_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="kilat_defect_image[other]"
                                                    id="other_kilat_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="kilat_defect_image[other_2]"
                                                    id="other_kilat_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Service --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.Service') }}</th>
                                            <td class="d-felx">
                                                <input type="checkbox" name="servis_defect[roof]" id="service_roof"
                                                    class="form-check">
                                                <label
                                                    for="service_roof">{{ __('messages.the_service_line_is_on_the_roof') }}</label>

                                            </td>
                                            <td>
                                                <input type="file" name="servis_defect_image[roof]"
                                                    id="service_roof-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="servis_defect_image[roof_2]"
                                                    id="service_roof-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="d-felx">
                                                <input type="checkbox" name="servis_defect[won_piece]"
                                                    id="service_won_piece" class="form-check">
                                                <label for="service_won_piece">{{ __('messages.won_piece_date') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="servis_defect_image[won_piece]"
                                                    id="service_won_piece-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="servis_defect_image[won_piece_2]"
                                                    id="service_won_piece-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="servis_defect[other]"
                                                    id="other_servis_defect" class="form-check">
                                                <label for="other_servis_defect">{{ __('messages.others') }} </label>
                                                <input type="text" name="servis_defect[other_input]"
                                                    id="other_servis_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="servis_defect_image[other]"
                                                    id="other_servis_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="servis_defect_image[other_2]"
                                                    id="other_servis_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>


                                        {{-- Grounding --}}

                                        <tr>
                                            <th rowspan="2">{{ __('messages.grounding') }}</th>
                                            <td>
                                                <input type="checkbox" name="pembumian_defect[netural]"
                                                    id="grounding_netural" class="form-check">
                                                <label
                                                    for="grounding_netural">{{ __('messages.no_connection_to_neutral') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="pembumian_defect_image[netural]"
                                                    id="grounding_netural-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="pembumian_defect_image[netural_2]"
                                                    id="grounding_netural-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="pembumian_defect[other]"
                                                    id="other_pembumian_defect" class="form-check">
                                                <label for="other_pembumian_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="pembumian_defect[other_input]"
                                                    id="other_pembumian_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="pembumian_defect_image[other]"
                                                    id="other_pembumian_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="pembumian_defect_image[other_2]"
                                                    id="other_pembumian_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Signage - OFF Point / Two Way Supply --}}
                                        <tr>
                                            <th rowspan="2">{{ __('messages.signage_off_point_two_way_supply') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="bekalan_dua_defect[damage]"
                                                    id="signage_damage" class="form-check">
                                                <label
                                                    for="signage_damage">{{ __('messages.faded_damaged_missing_signage') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="bekalan_dua_defect_image[damage]"
                                                    id="signage_damage-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="bekalan_dua_defect_image[damage_2]"
                                                    id="signage_damage-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="checkbox" name="bekalan_dua_defect[other]"
                                                    id="other_bekalan_dua_defect" class="form-check">
                                                <label for="other_bekalan_dua_defect">{{ __('messages.others') }}</label>
                                                <input type="text" name="bekalan_dua_defect[other_input]"
                                                    id="other_bekalan_dua_defect-input" placeholder="mention other defect"
                                                    required class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="bekalan_dua_defect_image[other]"
                                                    id="other_bekalan_dua_defect-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="bekalan_dua_defect_image[other_2]"
                                                    id="other_bekalan_dua_defect-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>

                                        {{-- Main Street --}}

                                        <tr>
                                            <th rowspan="3">{{ __('messages.main_street') }}</th>
                                            <td class="d-flex">
                                                <input type="checkbox" name="kaki_lima_defect[date_wire]"
                                                    id="street_date_wire" class="form-check">
                                                <label for="street_date_wire">{{ __('messages.date_wire') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="kaki_lima_defect_image[date_wire]"
                                                    id="street_date_wire-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="kaki_lima_defect_image[date_wire_2]"
                                                    id="street_date_wire-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="d-flex">
                                                <input type="checkbox" name="kaki_lima_defect[burn]" id="street_burn"
                                                    class="form-check">
                                                <label
                                                    for="street_burn">{{ __('messages.junction_box_date_burn_effect') }}</label>
                                            </td>
                                            <td>
                                                <input type="file" name="kaki_lima_defect_image[burn]"
                                                    id="street_burn-image" class="d-none form-control" accept="image/*">
                                                <input type="file" name="kaki_lima_defect_image[burn_2]"
                                                    id="street_burn-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="kaki_lima_defect[other]"
                                                    id="other_kaki_lima_defect_image" class="form-check">
                                                <label
                                                    for="other_kaki_lima_defect_image">{{ __('messages.others') }}</label>
                                                <input type="text" name="kaki_lima_defect[other_input]"
                                                    id="other_kaki_lima_defect_image-input"
                                                    placeholder="mention other defect" required
                                                    class="form-control d-none">
                                            </td>
                                            <td>
                                                <input type="file" name="kaki_lima_defect_image[other]"
                                                    id="other_kaki_lima_defect_image-image" class="d-none form-control"
                                                    accept="image/*">
                                                <input type="file" name="kaki_lima_defect_image[other_2]"
                                                    id="other_kaki_lima_defect_image-image-2" class="d-none form-control"
                                                    accept="image/*">

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <input type="hidden" name="total_defects" id="total_defects">

                            </fieldset>




                            <h3>{{ __('messages.Heigh_Clearance') }}</h3>

                            {{-- START Heigh Clearance (4) --}}

                            <fieldset class="form-input high-clearance">
                                <h3>{{ __('messages.Heigh_Clearance') }}</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead style="background-color: #E4E3E3 !important">
                                            <th class="col-4">{{ __('messages.title') }}</th>
                                            <th class="col-4">{{ __('messages.defects') }}</th>
                                            <th class="col-4">{{ __('messages.images') }}</th>
                                        </thead>

                                        <tbody>

                                            {{-- Site Conditions --}}

                                            <tr>
                                                <th rowspan="3">{{ __('messages.Site_Conditions') }}</th>
                                                <td class="d-flex">
                                                    <input type="checkbox" name="tapak_condition[road]" id="site_road"
                                                        class="form-check">
                                                    <label for="site_road">{{ __('messages.Crossing_the_Road') }}</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="tapak_road_img" id="site_road-img"
                                                        class="form-control d-none" accept="image/*">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tapak_condition[side_walk]"
                                                        id="side_walk" class="form-check">
                                                    <label for="side_walk">{{ __('messages.Sidewalk') }}</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="tapak_sidewalk_img" id="side_walk-img"
                                                        class="form-control d-none" accept="image/*">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tapak_condition[vehicle_entry]"
                                                        id="vehicle_entry" class="form-check">
                                                    <label
                                                        for="vehicle_entry">{{ __('messages.No_vehicle_entry_area') }}</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="tapak_no_vehicle_entry_img"
                                                        id="vehicle_entry-img" class="form-control d-none" >
                                                </td>
                                            </tr>

                                            {{-- Area --}}
                                            <tr>
                                                <th rowspan="4">{{ __('messages.Area') }}</th>
                                                <td class="d-flex">
                                                    <input type="checkbox" name="kawasan[bend]" id="area_bend"
                                                        class="form-check">
                                                    <label for="area_bend">{{ __('messages.Bend') }}</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="kawasan_bend_img" id="area_bend-img"
                                                        class="form-control d-none" accept="image/*">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[road]" id="area_road"
                                                        class="form-check">
                                                    <label for="area_road"> {{ __('messages.Road') }}</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="kawasan_road_img" id="area_road-img"
                                                        class="form-control d-none" accept="image/*">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[forest]" id="area_forest"
                                                        class="form-check">
                                                    <label for="area_forest">{{ __('messages.Forest') }} </label>
                                                </td>
                                                <td>
                                                    <input type="file" name="kawasan_forest_img" id="area_forest-img"
                                                        class="form-control d-none" accept="image/*">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="kawasan[other]" id="area_other"
                                                        class="form-check">
                                                    <label for="area_other">{{ __('messages.others') }}
                                                        {{-- (please state) --}} </label>
                                                    <input type="text" name="kawasan[other_input]"
                                                        id="area_other-input" class="form-control d-none" required
                                                        placeholder="(please state)">
                                                </td>
                                                <td>
                                                    <input type="file" name="kawasan_other_img" id="area_other-img"
                                                        class="form-control d-none" accept="image/*">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="jarak_kelegaan">{{ __('messages.Clearance_Distance') }}</label></div>
                                    <div class="col-md-4"><input type="number" name="jarak_kelegaan"
                                            id="jarak_kelegaan" class="form-control"></div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="">{{ __('messages.Line_clearance_specifications') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="talian_spec" value="comply" id="line-comply"
                                                    class="form-check"><label for="line-comply">
                                                    {{ __('messages.Comply') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="talian_spec" value="uncomply"
                                                    id="line-disobedient" class="form-check"><label
                                                    for="line-disobedient">Uncomply</label>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            {{-- END Heigh Clearance (4) --}}


                            <h3>{{ __('messages.Kebocoran_Arus') }}</h3>


                            {{-- START Kebocoran Arus (5) --}}

                            <fieldset class="form-input">
                                <h3>{{ __('messages.Kebocoran_Arus') }}</h3>

                                <div class="row">
                                    <div class="col-md-4"><label
                                            for="">{{ __('messages.Inspection_of_current_leakage_on_the_pole') }}
                                        </label></div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="arus_pada_tiang" id="arus_pada_tiang_no"
                                                    class="form-check" value="No"><label for="arus_pada_tiang_no">

                                                    {{ __('messages.no') }}</label>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                <input type="radio" name="arus_pada_tiang" id="arus_pada_tiang_yes"
                                                    class="form-check" value="Yes"><label
                                                    for="arus_pada_tiang_yes">
                                                    {{ __('messages.yes') }}</label>
                                            </div>

                                            <div class="col-md-4 d-none  " id="arus_pada_tiang_amp_div">
                                                <label for="arus_pada_tiang_amp">
                                                    {{ __('messages.Amp') }}</label>
                                                <input type="text" name="arus_pada_tiang_amp"
                                                    id="arus_pada_tiang_amp" class="form-control" required>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            {{-- END Kebocoran Arus (5) --}}


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="{{ URL::asset('assets/test/js/jquery.steps.js') }}"></script>

    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="{{ URL::asset('map/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js') }}"></script>

    <script>
        var form = $("#framework-wizard-form").show();
        form
            .steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",

                onStepChanging: function(event, currentIndex, newIndex) {
                    if (currentIndex > newIndex) {
                        return true;
                    }

                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },




                onFinished: function(event, currentIndex) {
                    form.submit();
                },
                // autoHeight: true,
            })

        function getWp(param) {
            var splitVal = param.value.split(',');
            addRemoveBundary(splitVal[1], splitVal[2], splitVal[3])

            $('#ba').val(splitVal[1])


        }

        function submitFoam() {
            if ($('#lat').val() == '' || $('#log').val() == '') {
                $('.map-error').html('Please select location')
                return false;
            } else {
                $('.map-error').html(' ')
            }
        }
    </script>
    <script type="text/javascript">
        var baseLayers
        var identifyme = '';
        var boundary3 = '';
        var marker = '';
        var boundary2 = '';
        map = L.map('map').setView([3.016603, 101.858382], 5);



        var st1 = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map); // satlite map

        var street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'); // street map

        // ADD MAPS
        baseLayers = {
            "Satellite": st1,
            "Street": street
        };


        boundary3 = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
            layers: 'cite:aero_apks',
            format: 'image/png',
            maxZoom: 21,
            transparent: true
        }, {
            buffer: 10
        })



        // ADD LAYERS GROUPED OVER LAYS
        groupedOverlays = {
            "POI": {
                'BA': boundary3,
            }
        };

        var layerControl = L.control.groupedLayers(baseLayers, groupedOverlays, {
            collapsed: true,
            position: 'topright'
            // groupCheckboxes: true
        }).addTo(map);



        // add boundary layer on page load
        map.addLayer(boundary3)
        map.setView([2.59340882301331, 101.07054901123], 8);


        // change layer and view when ba change
        function addRemoveBundary(param, paramY, paramX) {

            if (boundary3 != '') {
                map.removeLayer(boundary3) // Remove on page load boundary
            }


            if (boundary2 !== '') { // boundary if eesixts then first reomve from map
                map.removeLayer(boundary2)
            }

            boundary2 = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
                layers: 'cite:ba',
                format: 'image/png',
                cql_filter: "station='" + param + "'", // add ba name for filter boundary
                maxZoom: 21,
                transparent: true
            }, {
                buffer: 10
            })

            map.addLayer(boundary2) // add filtered boundary
            boundary2.bringToFront()

            map.setView([parseFloat(paramY), parseFloat(paramX)], 10); // set view






        }

        // on click map add marker and bind popup
        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng);
            map.addLayer(marker);
            marker.bindPopup("<b>You clicked the map at " + e.latlng.toString()).openPopup();

            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            $('#lat').val(lat);
            $('#log').val(lng);
            $('#cordinates').val(e.latlng);
        }

        map.on('click', onMapClick);
    </script>

    <script>
        const b1Options = [
            ['W1', 'KUALA LUMPUR PUSAT', 3.14925905877391, 101.754098819705],
            ['B1', 'PETALING JAYA', 3.1128074178475, 101.605270457169],
            ['B1', 'RAWANG', 3.47839445121726, 101.622905486475],
            ['B1', 'KUALA SELANGOR', 3.40703209426401, 101.317426926947],
            ['B2', 'KLANG', 3.08428642705789, 101.436185279023],
            ['B2', 'PELABUHAN KLANG', 2.98188527916042, 101.324234779569],
            ['B4', 'CHERAS', 3.14197346621987, 101.849883983416],
            ['B4', 'BANTING', 2.82111390453244, 101.505890775541],
            ['B4', 'BANGI', 2.965810949933260, 101.81881303103104],
            ['B4', 'PUTRAJAYA & CYBERJAYA', 2.92875032271019, 101.675338316575]
        ];

        const userBa = "{{ Auth::user()->ba }}";
        $(document).ready(function() {



            if (userBa !== '') {
                getBaPoints(userBa)
            }

            $('.defects input[type="checkbox"]').on('click', function() {
                addReomveImageField(this)

            })
            $('.high-clearance input[type="checkbox"]').on('click', function() {
                addReomveImageHighClearanceField(this)

            })
            $('input[name="arus_pada_tiang"]').on('change', function() {
                if (this.value == 'Yes') {
                    if ($('#arus_pada_tiang_amp_div').hasClass('d-none')) {
                        $('#arus_pada_tiang_amp_div').removeClass('d-none');
                    }
                } else {
                    if (!$('#arus_pada_tiang_amp_div').hasClass('d-none')) {
                        $('#arus_pada_tiang_amp_div').addClass('d-none');
                    }
                }
            })


            $('.select-radio-value').on('change',function(){
                var val = this.value;
                var id = `${this.name}_input`;
                var input = $(`#${id}`)
                if (val === 'other') {
                    input.val('');
                    input.removeClass('d-none');
                }else{
                    input.val(val);
                    if (!input.hasClass('d-none')) {
                        input.addClass('d-none')
                    }
                }
            });

        });

        var total_defects = 0;

        function addReomveImageField(checkbox) {
            var element = $(checkbox);
            var id = element.attr('id');
            var input = $(`#${id}-image`)
            var input_2 = $(`#${id}-image-2`)
            var input_val = $(`#${id}-input`)

            if (checkbox.checked) {
                if (input.hasClass('d-none')) {
                    input.removeClass('d-none');
                    input_2.removeClass('d-none');
                    input_val.removeClass('d-none');
                    total_defects += 1;
                }
            } else {

                if (!input.hasClass('d-none')) {
                    input.addClass('d-none');
                    input_2.addClass('d-none');
                    input_val.addClass('d-none');
                    input_val.val('');
                    total_defects -= 1;
                    if (input.hasClass('error')) {
                        input.removeClass('error')
                        input_2.removeClass('error')
                    }
                    var span = input.parent().find('label');
                    if (span.length > 0) {
                        span.html('')
                    }
                    var span_val = $(`#${id}-input-error`);
                    if (span_val.length > 0) {
                        span_val.html('')
                    }
                }
                console.log('unchecked');
            }

            $('#total_defects').val(total_defects)

        }


        function addReomveImageHighClearanceField(checkbox) {
            var element = $(checkbox);
            var id = element.attr('id');
            var input = $(`#${id}-img`)
            var input_val = $(`#${id}-input`)

            if (checkbox.checked) {
                if (input.hasClass('d-none')) {
                    input.removeClass('d-none');

                    input_val.removeClass('d-none');

                }
            } else {

                if (!input.hasClass('d-none')) {
                    input.addClass('d-none');


                    input_val.addClass('d-none');
                    input_val.val('');

                    if (input.hasClass('error')) {
                        input.removeClass('error')

                    }
                    var span = input.parent().find('label');
                    if (span.length > 0) {
                        span.html('')
                    }

                    var span_val = $(`#${id}-input-error`);
                    if (span_val.length > 0) {
                        span_val.html('')
                    }
                }

            }
        }


        function getBaPoints(param) {
            var baSelect = $('#ba_s')
            baSelect.empty();

            b1Options.map((data) => {
                if (data[1] == param) {
                    baSelect.append(`<option value="${data}">${data[1]}</option>`)
                }
            });
            let baVal = document.getElementById('ba_s');
            getWp(baVal)
        }


        function getMainLine(val){
            // if (val == 'service_line') {
            //     $('#main_line_connection').removeClass('d-none')
            // }else{
            //     if (!$('#main_line_connection').hasClass('d-none')) {
            //     $('#main_line_connection').addClass('d-none')
            //     $('#main_line_connection_one , #main_line_connection_many').prop('checked', false);
            //     }
            // }
        }
    </script>
@endsection
