
@php
    $post_catalogue_id = old('post_catalogue_id',(isset($post->post_catalogue_id)) ? $post->post_catalogue_id :  '');
    $publish = old('publish',(isset($post->publish)) ? $post->publish  :  '');
    $follow = old('follow',(isset($post->follow)) ? $post->follow :  '');
@endphp
<div class="ibox">
    <div class="ibox-title">
            <h5>Chọn danh mục cha <span class="text-danger">(*)</span></h5>
        </div>
        <div class="ibox-content">
            <div class="row mb15">
                <div class="col-lg-12">
                    <div class="form-row">

                        <span class="text-danger notice">*Chọn root nếu không có danh mục cha</span>
                        <select name="post_catalogue_id" class="form-control setUpSelect2" id="">
                            @foreach ($dropDown as $key => $val)
                                    <option @selected($post_catalogue_id==$key) value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                        @error('post_catalogue_id')
                        <div class="error-message">* {{ $message }}</div>
                        @enderror
                </div>
            </div>
            @php
            $catalogue = [];
            if(isset($post)){
                foreach($post->post_catalogues as $key => $val){
                    $catalogue[] = $val->id;
                }
            }
        @endphp
            <div class="row ">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label class="control-label text-left">Chọn danh mục phụ</label>
                        <select name="catalogue[]" class="form-control setUpSelect2" id="" multiple>
                            @foreach ($dropDown as $key => $val)
                                    <option
                            @if(is_array(old('catalogue[]', (
                                isset($catalogue) && count($catalogue)) ?   $catalogue : [])
                                ) && isset($post->post_catalogue_id) &&   in_array($key, old('catalogue', (isset($catalogue)) ? $catalogue : []))
                            )
                            selected
                            @endif value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                        @error('catalogue')
                        <div class="error-message">* {{ $message }}</div>
                        @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5>Chọn ảnh đại diện</h5>
        </div>
        <div class="ibox-content">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="form-row">
                        <span class="image img-cover image-target">
                            <img class="" src="{{asset(old('image',(isset($post->image) ? $post->image :  'backend/img/no-img.jpg')))}}" alt="">
                        </span>
                        <input
                            type="hidden"
                            name="image"
                            value="{{old('image',($post->image) ?? '')}}">
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
            <h5>Cấu hình nâng cao</h5>
        </div>
        <div class="ibox-content">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="form-row mb15">
                        <select name="publish" class="form-control setUpSelect2">
                            @foreach (config('apps.general.publish') as $key => $val)
                            <option @selected($publish==$key) value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <select name="follow" class="form-control setUpSelect2">
                            @foreach (config('apps.general.follow') as $key => $val)
                            <option @selected($follow==$key) value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
