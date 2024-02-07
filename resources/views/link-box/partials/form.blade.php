

    {{-- ZONE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4 "><label for="zone">{{ __('messages.zone') }}</label></div>
        <div class="col-md-4  col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->zone }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- BA --}}
    <div class="row">
        <div class="col-md-4 col-sm-4    "><label for="ba">{{ __('messages.ba') }}</label></div>
        <div class="col-md-4   col-sm-6 ">
            <input type="text" name=""  id="" value="{{ $data->ba }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- TO --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="end_date">{{__('messages.to')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="end_date" id="end_date" value="{{ $data->end_date }}" class="form-control">
        </div>
    </div>

    {{-- FROM --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="start_date">{{__('messages.from')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="start_date" id="start_date" value="{{ $data->start_date }}" class="form-control">
        </div>
    </div>

    {{-- TYPE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="type">{{ __('messages.type') }}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->type }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
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
        <div class="col-md-4 col-sm-4"><label for="coordinate">{{__("messages.coordinate")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="coordinate" id="coordinate" value="{{ $data->coordinate }}" class="form-control" required readonly>
        </div>
    </div> 

    {{-- COVER IS NOT CLOSED --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="cover_status">{{__("messages.cover_is_not_closed")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->cover_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- VANDALISM --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="vandalism_status">{{__("messages.vandalism")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->vandalism_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- LEANING --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="leaning_status">{{__("messages.leaning")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->leaning_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- LEANING ANGLE --}}
    <div class="row @if ($data->leaning_status == 'No') d-none @endif " id="leaning-angle">
        <div class="col-md-4 col-sm-4"><label for="leaning_angle">{{__('messages.leaning_angle')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input {{$disabled ? 'disabled' : '' }}  type="text" name="leaning_angle" id="leaning_angle" value="{{ $data->leaning_angle }}" class="form-control">
        </div>
    </div>

    {{-- RUSTY --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="rust_status">{{__('messages.rusty')}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->rust_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- PAINT FADED --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="paint_status">{{ __('messages.paint_faded') }}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->paint_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- CLEANING ILLEAGAL ADS BANNERS --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="advertise_poster_status">{{__("messages.cleaning_illegal_ads_banners")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->advertise_poster_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- BUSHY --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="bushes_status">{{__("messages.bushy")}}</label></div>
        <div class="col-md-4 col-sm-6">
            <input type="text" name=""  id="" value="{{ $data->bushes_status }}" class="form-control" {{$disabled ? 'disabled' : ''}}>
        </div>
    </div>

    {{-- LINK BOX IMAGES 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="link_box_image">{{__("messages.link_box")}} {{__("messages.images")}} </label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->link_box_image_1 , 'link_box_image_1' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->link_box_image_2 , 'link_box_image_2' , $disabled )  !!}
        </div>
        {{-- </div> --}}
    </div>

    {{-- COVER IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_gate">{{__('messages.cover_image')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_cover , 'image_cover' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_cover_2 , 'image_cover_2' , $disabled )  !!}
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

    {{-- IMAGE LEANING 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_leaning">{{__("messages.image_leaning")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_leaning , 'image_leaning' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_leaning_2 , 'image_leaning_2' , $disabled )  !!}
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

    {{-- IMAGE ADVERTISE POSTER 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="images_advertise_poster">{{__('messages.image_advertise_poster')}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->images_advertise_poster , 'images_advertise_poster' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->images_advertise_poster_2 , 'images_advertise_poster_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE BUSHES 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="images_bushes">{{__("messages.image_bushes")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->images_bushes , 'images_bushes' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->images_bushes_2 , 'images_bushes_2' , $disabled )  !!}
        </div>
    </div>

    {{-- IMAGE ADVERSITE POSTER REMOVAL IMAGE 1 & 2 --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="image_advertisement_after_1">{{__("messages.image_advertise_poster_removal")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->image_advertisement_after_1 , 'image_advertisement_after_1' , $disabled )  !!}
            {!!  viewAndUpdateImage($data->image_advertisement_after_2 , 'image_advertisement_after_2' , $disabled )  !!}
        </div>
    </div>

    {{-- OTHER IMAGE --}}
    <div class="row">
        <div class="col-md-4 col-sm-4"><label for="other_image">{{__("messages.other_image")}}</label></div>
        <div class="col-md-8 col-sm-8 row">
            {!!  viewAndUpdateImage($data->other_image , 'other_image' , $disabled )  !!}
        </div>
    </div>