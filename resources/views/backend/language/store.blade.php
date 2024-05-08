@include('backend.dashboard.component.breadcumb',['title'=>$config['seo'][$config['method']]['title']])
@php
    $form_action = ($config['method']=='edit') ? route('language.update',['id'=>$language->id]): route('language.store');
@endphp
<form action="{{$form_action}}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p> - Nhập thông tin chung của ngôn ngử sử dụng</p>
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
                                        Tên ngôn ngữ <span class="text-danger">(*)</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{old('name',($language->name) ?? '')}} "
                                        class="form-control"
                                        placeholder="VD: Tiếng việt"
                                        autocomplete="off"
                                    >
                                </div>
                                 @error('name')
                                    <div class="error-message">* {{ $message }}</div>
                                 @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                       Canonical <span class="text-danger">(*)</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="canonical"
                                        value="{{old('canonical',($language->canonical) ?? '')}} "
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                                @error('canonical')
                                    <div class="error-message">* {{ $message }}</div>
                                 @enderror
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Ảnh
                                    </label>
                                    <input
                                        type="text"
                                        name="image"
                                        value="{{old('image',($language->image) ?? '')}} "
                                        class="form-control upload-image"
                                        placeholder="VD: Tiếng việt"
                                        data-type='Images'
                                        autocomplete="off"
                                    >
                                </div>
                                 @error('image')
                                    <div class="error-message">* {{ $message }}</div>
                                 @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                       Ghi chú
                                    </label>
                                    <input
                                        type="text"
                                        name="description"
                                        value="{{old('description',($language->description) ?? '')}} "
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
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

