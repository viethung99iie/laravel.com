@php
$parent_id = old(
'parent_id',
isset($post->parent_id) ? $post->parent_id : '',
);
$publish = old(
'publish',
isset($post->publish) ? $post->publish : '',
);
$follow = old(
'follow',
isset($post->follow) ? $post->follow : '',
);
@endphp
<div class="ibox">
    <div class="ibox-content">
        <div class="row ">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="post_catalogue_id" class="control-label text-left">
                        {{ __('messages.parent') }}<span class="text-danger">(*)</span>
                    </label>
                    <span class="text-danger notice">{{ __('messages.parentNotice') }}</span>
                    <select name="parent_id" class="form-control setUpSelect2" id="">
                        @foreach ($dropDown as $key => $val)
                        <option @selected($parent_id==$key) value="{{ $key }}">{{ $val }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @error('parent_id')
                <div class="error-message">* {{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.image') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row ">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="image img-cover image-target">
                        {{-- <img class="" src="{{asset(old('image')?? 'backend/img/no-img.jpg')}}" alt=""> --}}

                        <img class="" src="{{ asset(old('image', isset($post->image) ? $post->image : 'backend/img/no-img.jpg')) }}" alt="">
                    </span>
                    <input type="hidden" name="image" value="{{ old('image', $post->image ?? '') }}">
                </div>
                @error('image')
                <div class="error-message">* {{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.advange') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row ">
            <div class="col-lg-12">
                <div class="form-row mb15">
                    <select name="publish" class="form-control setUpSelect2">
                        @foreach (config('apps.general.publish') as $key => $val)
                        <option @selected($publish==$key) value="{{ $key }}">{{ $val }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <select name="follow" class="form-control setUpSelect2">
                        @foreach (config('apps.general.follow') as $key => $val)
                        <option @selected($follow==$key) value="{{ $key }}">
                            {{ $val }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
