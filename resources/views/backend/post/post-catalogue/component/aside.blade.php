
@php
    $parent_id = old('parent_id',(isset($postCatalogue->parent_id)) ? $postCatalogue->parent_id :  '');
    $publish = old('publish',(isset($postCatalogue->publish)) ? $postCatalogue->publish  :  '');
    $follow = old('follow',(isset($postCatalogue->follow)) ? $postCatalogue->follow :  '');
@endphp
<div class="ibox">
                    <div class="ibox-content">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="post_catalogue_id" class="control-label text-left">
                                    Chọn danh mục cha <span class="text-danger">(*)</span>
                                    </label>
                                    <span class="text-danger notice">*Chọn root nếu không có danh mục cha</span>
                                    <select name="parent_id" class="form-control setUpSelect2" id="">
                                        @foreach ($dropDown as $key => $val)
                                             <option @selected($parent_id==$key) value="{{$key}}">{{$val}}</option>
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
                        <h5>Chọn ảnh đại diện</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <span class="image img-cover image-target">
                                        {{-- <img class="" src="{{asset(old('image')?? 'backend/img/no-img.jpg')}}" alt=""> --}}

                                        <img class="" src="{{asset(old('image',(isset($postCatalogue->image) ? $postCatalogue->image :  'backend/img/no-img.jpg')))}}" alt="">
                                    </span>
                                    <input
                                        type="hidden"
                                        name="image"
                                        value="{{old('image',($postCatalogue->image) ?? '')}}">
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
