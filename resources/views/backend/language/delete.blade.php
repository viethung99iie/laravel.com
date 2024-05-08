@include('backend.dashboard.component.breadcumb',['title'=>$config['seo']['delete']['title']])
<form action="{{route('language.destroy',$language->id)}}" class="box" method="post">
    @csrf
    @method('Delete')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p> - Thông tin ngôn ngữ bạn muốn xóa là : </p>
                        <p> - Lưu ý: Không thể khôi phục dữ liệu sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này.</p>
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
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
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
                                        readonly
                                    >
                                </div>
                                @error('canonical')
                                    <div class="error-message">* {{ $message }}</div>
                                 @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button type="submit" class="btn btn-danger" value="send" name="send">Xác nhận xóa</button>
        </div>
    </div>
</form>
