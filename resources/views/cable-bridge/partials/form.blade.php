
    {{-- ZONE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4 col-sm-4 "><label for="zone">{{ __('messages.zone') }}</label></div>
        <div class="col-md-4   col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->zone }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- BA --}}
    <div class="row">
        <div class="col-md-4 col-sm-4 col-sm-4 "><label for="ba">{{ __('messages.ba') }}</label></div>
        <div class="col-md-4   col-sm-6 ">
            <input type="text" name=""  id="" value="{{ $data->ba }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- TO --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="end_date_">{{__("messages.to")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->end_date_ }}" class="form-control" >
        </div>
    </div>

    {{-- FROM --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="start_date">{{__("messages.from")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="start_date" id="start_date" value="{{ $data->start_date }}" class="form-control" >
        </div>
    </div>

    {{-- VOLTAGE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="area">{{ __('messages.voltage') }}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->voltage }}" class="form-control" >
        </div>
    </div>

    {{-- SURVEY DATE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="visit_date">{{__("messages.survey_date")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="date" name="visit_date" id="visit_date" class="form-control" value="{{ date('Y-m-d', strtotime($data->visit_date)) }}" required>
        </div>
    </div>

    {{-- PATROL TIME --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="patrol_time">{{__("messages.patrol_time")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="time" name="patrol_time" id="patrol_time" class="form-control" value="{{ date('H:i:s', strtotime($data->patrol_time)) }}" required>
        </div>
    </div>

    {{-- COORDINATE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="coords">{{__("messages.coordinate")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="coords" id="coords" value="{{ $data->coords }}" class="form-control" required readonly>
        </div>
    </div>
 
    {{-- VANDALISM --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="vandalism_status">{{__("messages.vandalism")}} </label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->vandalism_status }}" class="form-control" >
        </div>
    </div>

    {{-- PIPE BROKEN --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="pipe_staus">{{__("messages.pipe_broken")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->pipe_staus }}" class="form-control" >
        </div>
    </div>

    {{-- COLLAPSED --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="collapsed_status">{{__("messages.collapsed")}} </label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->collapsed_status }}" class="form-control" >
        </div>
    </div>

    {{-- RUSTY --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="rust_status">{{__("messages.rusty")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->rust_status }}" class="form-control" >
        </div>
    </div>


    {{-- DANGER SIGN --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="danger_sign">{{__("messages.danger_sign")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->danger_sign }}" class="form-control" >
        </div>
    </div>

    {{-- ANTI CROSSING DEVICE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="anti_crossing_device">{{__("messages.anti_crossing_device")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->anti_crossing_device }}" class="form-control" >
        </div>
    </div>

    {{-- LEANING --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="condong">{{__("messages.leaning")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->condong }}" class="form-control" >       
        </div>
    </div>

    {{-- TREAPASS --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="pencerobohan">{{__("messages.trespass")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->pencerobohan }}" class="form-control" >

        </div>
    </div>  

    {{-- BUSHY --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="bushes_status">{{__("messages.bushy")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->bushes_status }}" class="form-control" >
        </div>
    </div>

    {{-- CLEANLINESS --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="kebersihan_jabatan">{{__("messages.cleanliness")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date_" id="end_date_" value="{{ $data->rust_status }}" class="form-control" >
        </div>
    </div>

    {{-- CABLE BRIDGE IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="cable_bridge_image">{{__("messages.cable_bridge")}} {{__("messages.images")}} </label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->cable_bridge_image_1 , 'cable_bridge_image_1' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->cable_bridge_image_2 , 'cable_bridge_image_2' , $disabled )  !!}
        </div>
    </div>

    {{-- VANDALISM IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_vandalism">{{__("messages.image_vandalism")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_vandalism , 'image_vandalism' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_vandalism_2 , 'image_vandalism_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE PIPE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_pipe">{{__("messages.image_pipe")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_pipe , 'image_pipe' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_pipe_2 , 'image_pipe_2' , $disabled )  !!}
        </div>
    </div>
 
    {{-- IMAGE COLLAPSED 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_collapsed">{{__("messages.image_collapsed")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_collapsed , 'image_collapsed' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_collapsed_2 , 'image_collapsed_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE RUST 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_rust">{{__("messages.image_rust")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_rust , 'image_rust' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_rust_2 , 'image_rust_2' , $disabled )  !!}
        </div>
    </div>


    {{-- DANGER SIGN IMAGE 1 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="danger_sign_img">{{__("messages.danger_sign")}} {{__("messages.image")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_vandalism , 'image_vandalism' , $disabled )  !!}
        </div>
    </div>

    {{-- ANTI CROSSING DECIVE IMAGE 1 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4 "><label for="anti_cross_device_img">{{__("messages.anti_crossing_device")}} {{__("messages.image")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->anti_cross_device_img , 'anti_cross_device_img' , $disabled )  !!}
        </div>
    </div>

    {{-- BUSHES IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="images_bushes">{{__("messages.image_bushes")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->images_bushes , 'images_bushes' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->images_bushes_2 , 'images_bushes_2' , $disabled )  !!}
        </div>
    </div>

    {{-- OHTER IMAGE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="other_image">{{__("messages.other_image")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->other_image , 'other_image' , $disabled )  !!}
        </div>
    </div>