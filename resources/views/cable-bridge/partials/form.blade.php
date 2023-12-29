<div class="row">
    <div class="col-md-4"><label for="zone">{{__("messages.zone")}}</label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="zone" id="search_zone" class="form-control" required>

            <option value="{{ $data->zone }}" hidden>{{ $data->zone }}</option>
            @if ( Auth::user()->ba == '' )
            <option value="W1">W1</option>
            <option value="B1">B1</option>
            <option value="B2">B2</option>
            <option value="B4">B4</option>
            @endif

        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="ba">{{__('messages.ba')}}</label></div>
    <div class="col-md-4"><select {{$disabled ? 'disabled' : '' }}  name="ba" id="ba" class="form-control" required
            onchange="getWp(this)">
            <option value="{{$data->ba}}" hidden>{{$data->ba}}</option>


        </select></div>
</div>
<div class="row">
    <div class="col-md-4"><label for="end_date">{{__("messages.to")}}</label></div>
    <div class="col-md-4">
        <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date" id="end_date" value="{{ $data->end_date }}"
            class="form-control" >
    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="start_date">{{__("messages.from")}}</label></div>
    <div class="col-md-4">
        <input {{$disabled ? 'disabled' : '' }}  type="text" name="start_date" id="start_date" value="{{ $data->start_date }}"
            class="form-control" >
    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="area">{{ __('messages.voltage') }}</label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="voltage" id="voltage" class="form-control"  >
            <option value="{{$data->voltage}}" hidden>{{$data->voltage == '' ? 'select' : $data->voltage}}select</option>
            <option value="11kw">11kv</option>
            <option value="13kw">13kv</option>
        </select>
    </div>
</div>



<div class="row">
    <div class="col-md-4"><label for="visit_date">{{__("messages.survey_date")}}</label></div>
    <div class="col-md-4">
        <input {{$disabled ? 'disabled' : '' }}  type="date" name="visit_date" id="visit_date" class="form-control"
            value="{{ date('Y-m-d', strtotime($data->visit_date)) }}" required>
    </div>
</div>




<div class="row">
    <div class="col-md-4"><label for="patrol_time">{{__("messages.patrol_time")}}</label></div>
    <div class="col-md-4">
        <input {{$disabled ? 'disabled' : '' }}  type="time" name="patrol_time" id="patrol_time" class="form-control"
            value="{{ date('H:i:s', strtotime($data->patrol_time)) }}" required>
    </div>
</div>



@if ($disabled)


<div class="row">
    <div class="col-md-4"><label for="coords">{{__("messages.coordinate")}}</label></div>
    <div class="col-md-4">
        <input {{$disabled ? 'disabled' : '' }}  type="text" name="coords" id="coords"
            value="{{ $data->coords }}" class="form-control" required readonly>
    </div>
</div>
@endif



<div class="row">
    <div class="col-md-4"><label for="vandalism_status">{{__("messages.vandalism")}} </label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="vandalism_status" id="vandalism_status" class="form-control" required>
            <option value="{{ $data->vandalism_status }}" hidden>{{ $data->vandalism_status }}</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>

        </select>

    </div>
</div>



<div class="row">
    <div class="col-md-4"><label for="pipe_staus">{{__("messages.pipe_broken")}}</label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="pipe_staus" id="pipe_staus" class="form-control" required>
            <option value="{{ $data->pipe_staus }}" hidden>{{ $data->pipe_staus }}</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>

        </select>

    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="collapsed_status">{{__("messages.collapsed")}} </label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="collapsed_status" id="collapsed_status" class="form-control" required>
            <option value="{{ $data->collapsed_status }}" hidden>{{ $data->collapsed_status }}</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>

        </select>

    </div>
</div>
<div class="row">
    <div class="col-md-4"><label for="rust_status">{{__("messages.rusty")}}</label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="rust_status" id="rust_status" class="form-control" required>
            <option value="{{ $data->rust_status }}" hidden>{{ $data->rust_status }}</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>

        </select>

    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="bushes_status">{{__("messages.bushy")}}</label></div>
    <div class="col-md-4">
        <select {{$disabled ? 'disabled' : '' }}  name="bushes_status" id="bushes_status" class="form-control" required>
            <option value="{{ $data->bushes_status }}" hidden>{{ $data->bushes_status }}</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>

        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="cable_bridge_image">{{__("messages.cable_bridge")}} {{__("messages.images")}} </label></div>

    <div class="col-md-8 row">
        {!!  viewAndUpdateImage($data->cable_bridge_image_1 , 'cable_bridge_image_1' , $disabled )  !!}

        {!!  viewAndUpdateImage($data->cable_bridge_image_2 , 'cable_bridge_image_2' , $disabled )  !!}

    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="image_pipe">{{__("messages.image_pipe")}}</label></div>

    <div class="col-md-8 row">

        {!!  viewAndUpdateImage($data->image_pipe , 'image_pipe' , $disabled )  !!}

        {!!  viewAndUpdateImage($data->image_pipe_2 , 'image_pipe_2' , $disabled )  !!}

    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="image_vandalism">{{__("messages.image_vandalism")}}</label></div>

    <div class="col-md-8 row">
        {!!  viewAndUpdateImage($data->image_vandalism , 'image_vandalism' , $disabled )  !!}

        {!!  viewAndUpdateImage($data->image_vandalism_2 , 'image_vandalism_2' , $disabled )  !!}


    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="image_collapsed">{{__("messages.image_collapsed")}}</label></div>

    <div class="col-md-8 row">

        {!!  viewAndUpdateImage($data->image_collapsed , 'image_collapsed' , $disabled )  !!}

        {!!  viewAndUpdateImage($data->image_collapsed_2 , 'image_collapsed_2' , $disabled )  !!}

    </div>

</div>

<div class="row">
    <div class="col-md-4"><label for="image_rust">{{__("messages.image_rust")}}</label></div>

    <div class="col-md-8 row">
        {!!  viewAndUpdateImage($data->image_rust , 'image_rust' , $disabled )  !!}

        {!!  viewAndUpdateImage($data->image_rust_2 , 'image_rust_2' , $disabled )  !!}

    </div>
</div>



<div class="row">
    <div class="col-md-4"><label for="images_bushes">{{__("messages.image_bushes")}}</label></div>

    <div class="col-md-8 row">
        {!!  viewAndUpdateImage($data->images_bushes , 'images_bushes' , $disabled )  !!}

        {!!  viewAndUpdateImage($data->images_bushes_2 , 'images_bushes_2' , $disabled )  !!}

    </div>
</div>

<div class="row">
    <div class="col-md-4"><label for="other_image">{{__("messages.other_image")}}</label></div>
    @if (!$disabled)


    <div class="col-md-4">
        <input    type="file" name="other_image" id="other_image" class="form-control">
    </div>
    @endif
    <div class="col-md-4 text-center mb-3">
        @if (file_exists(public_path($data->other_image)) && $data->other_image != '')
            <a href="{{ URL::asset($data->other_image) }}" data-lightbox="roadtrip">
                <img src="{{ URL::asset($data->other_image) }}" alt=""
                    height="70" class="adjust-height ml-5  "></a>
        @else
            <strong>{{__("messages.no_image_found")}}</strong>
        @endif
    </div>
</div>
