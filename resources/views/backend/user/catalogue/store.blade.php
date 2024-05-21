@include('backend.dashboard.component.breadcrumb',['title'=>$config['seo'][$config['method']]['title']])
@php
$form_action = ($config['method']=='edit') ? route('user.catalogue.update',['id'=>$userCatalogue->id]): route('user.catalogue.store');
@endphp
<form action="{{$form_action}}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p> - Nhập thông tin chung của nhóm thành viên</p>
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
                                        Tên nhóm thành viên <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{old('name',($userCatalogue->name) ?? '')}} " class="form-control" placeholder="VD: Quản trị viên" autocomplete="off">
                                </div>
                                @error('name')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Ghi chú
                                    </label>
                                    <input type="text" name="description" value="{{old('description',($userCatalogue->description) ?? '')}} " class="form-control" placeholder="" autocomplete="off">
                                </div>
                                @error('description')
                                <div class="error-message">* {{ $message }}</div>
                                @enderror
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
