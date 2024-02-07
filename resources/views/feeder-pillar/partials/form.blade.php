
    {{-- ZONE --}}
    <div class="row">
        <div class="col-md-4  col-sm-4 "><label for="zone">{{ __('messages.zone') }}</label></div>
        <div class="col-md-4   col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->zone }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- BA --}}
    <div class="row">
        <div class="col-md-4     col-sm-4 "><label for="ba">{{ __('messages.ba') }}</label></div>
        <div class="col-md-4    col-sm-6 ">
            <input type="text" name=""  id="" value="{{ $data->ba }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- SURVEY DATE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="visit_date">{{__('messages.survey_date')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="date" name="visit_date" id="visit_date" class="form-control" value="{{ date('Y-m-d', strtotime($data->visit_date)) }}" required>
        </div>
    </div>

    {{-- PATROL TIME --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="patrol_time">{{__('messages.patrol_time')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="time" name="patrol_time" id="patrol_time" class="form-control" value="{{ date('H:i:s', strtotime($data->patrol_time)) }}" required>
        </div>
    </div>
 
    {{-- COORDINATE --}}    
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="coordinate">{{__('messages.coordinate')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->coordinate }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>
 
    {{-- SIZE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="size">{{__('messages.size')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->size }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- GATE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="name">{{__('messages.gate')}}</label></div>
        <div class="col-md-4 col-sm-6">

            {{-- GATE UNLOACKED --}}
            <div class=" d-flex">
                <input {{$disabled ? 'disabled' : '' }}  type="checkbox" name="gate_status[unlocked]" value="unlocked" {{ substaionCheckBox('unlocked', $data->gate_status) }} id="gate_status_unlocked">
                <label for="gate_status_unlocked">{{__("messages.unlocked")}}</label>
            </div>

            {{-- GATE DEMAGED --}}
            <div class=" d-flex">
                <input {{$disabled ? 'disabled' : '' }}  type="checkbox" name="gate_status[demaged]" {{ substaionCheckBox('demaged', $data->gate_status) }} id="gate_status_demaged">
                <label for="gate_status_demaged">{{__("messages.demaged")}}</label>
            </div>

            {{-- GATE OTHER --}}
            <div class="d-flex">
                <input {{$disabled ? 'disabled' : '' }}  type="checkbox" name="gate_status[other]" {{ substaionCheckBox('other', $data->gate_status) }} id="gate_status_others" onclick="getStatus(this)">
                <label for="gate_status_others">{{__("messages.others")}}</label>
            </div>

            {{-- OTHER INPUT --}}
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="gate_status[other_value]" id="gate_status_other"
            class="form-control  @if (substaionCheckBox('other', $data->gate_status) !== 'checked') d-none @endif"
            value="@if (substaionCheckBox('other', $data->gate_status) == 'checked') {{ $data->gate_status->other_value }} @endif"
            placeholder="please enter other gate defect">
        </div>
    </div>

    {{-- VANDALISM --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="type">{{__('messages.vandalism')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->vandalism_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- LEANING --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="leaning_staus">{{__('messages.leaning')}} </label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->leaning_staus }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- LEANING ANGEL --}}
    <div class="row @if ($data->leaning_staus == 'No') d-none @endif " id="leaning-angle">
        <div class="col-md-4 col-sm-4"><label for="leaning_angle">{{__('messages.leaning_angle')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="leaning_angle" id="leaning_angle"  value="{{ $data->leaning_angle }}" class="form-control">
        </div>
    </div>

    {{-- RUSTY --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="voltage">{{__('messages.rusty')}} </label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->rust_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- FP GAURD --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="fp_gaurd">{{ __('messages.fp_gaurd') }}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->guard_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- PAINT FADED --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="paint_status">{{ __('messages.paint_faded') }}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->paint_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- ADVERTISE POSTER STATUS --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="advertise_poster_status">{{__('messages.cleaning_illegal_ads_banners')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->advertise_poster_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- FEEDER PILLAR IMAGES 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="feeder_pillar_image">{{__('messages.feedar_piller')}} {{__("messages.images")}} </label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->feeder_pillar_image_1 , 'feeder_pillar_image_1' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->feeder_pillar_image_2 , 'feeder_pillar_image_2' , $disabled )  !!}
        </div>
    </div>

    {{-- NAME PLATE IMAGE 1 --}}

    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_name_plate">{{__('messages.name_plate')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_name_plate , 'image_name_plate' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE GATE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_pipe">{{__('messages.image_gate')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_gate , 'image_gate' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_gate_2 , 'image_gate_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE VANDALISM 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_vandalism">{{__('messages.image_vandalism')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_vandalism , 'image_vandalism' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_vandalism_2 , 'image_vandalism_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE  LEANING --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_leaning">{{__('messages.image_leaning')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_leaning , 'image_leaning' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_leaning_2 , 'image_leaning_2' , $disabled )  !!}
        </div>
    </div>

    {{-- RUST IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_rust">{{__("messages.image_rust")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_rust , 'image_rust' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_rust_2 , 'image_rust_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE ADVERTISEMENT POSTER 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="images_advertise_poster">{{__("messages.image_advertise_poster")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->images_advertise_poster , 'images_advertise_poster' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->images_advertise_poster_2 , 'images_advertise_poster_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE ADVERTISEMENT POSTER REMOVAL IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <label for="image_advertisement_after_1">{{__("messages.image_advertise_poster_removal")}}</label>
        </div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_advertisement_after_1 , 'image_advertisement_after_1' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_advertisement_after_2 , 'image_advertisement_after_2' , $disabled )  !!}
        </div>
    </div>

    {{-- OTHER IMAGE --}}

    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="other_image">{{__('messages.other_image')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->other_image , 'other_image' , $disabled )  !!}
        </div>
    </div>

    @if ($data->total_defects > 0)
    {{-- REPIAR DATE FORM --}}
    <form action="{{ route('feeder-pillar.update',[app()->getLocale(),$data->id]) }} " id="myForm"
        method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        {{-- SHOW REPAIR DATE --}}
        @if ($data->repair_date != '')
            <div class="row">
                <div class="col-md-4 col-sm-6"><label for="repair_date">Repair Date</label></div>
                <div class="col-md-4 col-sm-6">
                    <input  disabled  type="date" id="repair_date" class="form-control" value="{{ date('Y-m-d' , strtotime($data->repair_date)) }}" required>
                </div>
            </div>
        @endif
        
        {{-- UPDATE REPAIR DATE --}}
        <div class="row">
            <div class="col-md-4 col-sm-6"><label for="repair_date">{{$data->repair_date != '' ?'Update ' : 'Add '}}Repair Date</label></div>
            <div class="col-md-4 col-sm-6">
                <input type="date" name="repair_date" id="repair_date" class="form-control" required>
            </div>
        </div>

        {{-- UPDATE BUTTON --}}
        <div class="text-center p-4">
            <button class="btn btn-sm btn-success"> <strong>{{ __('messages.update') }}</strong></button>
        </div>

    </form>

    @endif