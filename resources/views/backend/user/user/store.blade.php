@include('backend.dashboard.component.breadcrumb',['title'=>$config['seo'][$config['method']]['title']])
@php
$form_action = ($config['method']=='edit') ? route('user.update',['id'=>$user->id]): route('user.store');
@endphp
<form action="{{$form_action}}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p> - Nhập thông tin chung của người sử dụng</p>
                        <p> - Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Email <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="email" value="{{old('email',($user->email) ?? '')}} " class="form-control" placeholder="" autocomplete="off">
                                </div>
                                @error('email')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Tên người dùng <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{old('name',($user->name) ?? '')}} " class="form-control" placeholder="" autocomplete="off">
                                </div>
                                @error('name')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @php
                        $user_catalogue = [
                        '0' => '[Chọn nhóm người dùng]',
                        '1' => 'Quản trị viên',
                        '1003' => 'Cộng tác viên',

                        ];
                        $user_catalogue_id = (isset($user->user_catalogue_id)) ? $user->user_catalogue_id : old('user_catalogue_id');
                        @endphp
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Nhóm người dùng
                                    </label>
                                    <select name="user_catalogue_id" id="" class="form-control">

                                        @foreach ($user_catalogue as $key => $value)
                                        <option value="{{$key}}" @if ($user_catalogue_id==$key) selected @endif>{{$value}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('user_catalogue_id')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Ngày sinh
                                    </label>
                                    <input type="date" name="birthday" value="{{old('birthday',(isset($user->birthday)) ? date('Y-m-d',strtotime($user->birthday)) : '')}}" class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        @if ($config['method'] == 'create')
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Mật khẩu <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="password" name="password" value="" class="form-control" placeholder="" autocomplete="off">
                                </div>
                                @error('password')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Nhập lại mật khẩu <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="password" name="re_password" value="" class="form-control" placeholder="" autocomplete="off">
                                </div>
                                @error('re_password')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Ảnh đại diện
                                    </label>
                                    <input type="text" name="image" value="{{old('email',($user->image) ?? '')}} " class="form-control upload-image" data-type='Images' placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @php

        @endphp
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin liên hệ</div>
                    <div class="panel-description">
                        <p> - Nhập thông tin liên hệ của người dùng</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Tỉnh/Thành Phố
                                    </label>
                                    <select name="province_id" id="" class="form-control setUpSelect2 province location" data-target='districts'>
                                        <option value="0">[Chọn Tỉnh/Thành Phố]</option>
                                        @if (isset($provinces))
                                        @foreach ($provinces as $item)
                                        <option value="{{$item->code}}" @if (old('province_id')==$item->code)
                                            selected
                                            @endif>{{$item->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Quận/Huyện
                                    </label>
                                    <select name="district_id" id="" class="form-control districts setUpSelect2 location" data-target='wards'>
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Phường/Xã
                                    </label>
                                    <select name="ward_id" id="" class="form-control setUpSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Địa Chỉ
                                    </label>
                                    <input type="text" name="address" value="{{old('address',($user->address) ?? '')}} " class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Số điện thoại
                                    </label>
                                    <input type="text" name="phone" value="{{old('phone',($user->phone) ?? '')}} " class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Ghi chú
                                    </label>
                                    <input type="text" name="description" value="{{old('description',($user->description) ?? '')}} " class="form-control" placeholder="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="text-right mb15">
            <button type="submit" class="btn btn-primary" value="send" name="send">Lưu Lại</button>
        </div>
    </div>
</form>
<script>
    let province_id = '{{isset($user->province_id) ? $user->province_id : old('
    province_id ')}}';
    let district_id = '{{isset($user->district_id) ? $user->district_id : old('
    district_id ')}}';
    let ward_id = '{{isset($user->ward_id) ? $user->ward_id : old('
    ward_id ')}}';

</script>
