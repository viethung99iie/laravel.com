@include('backend.dashboard.component.breadcrumb',['title'=>$config['seo']['delete']['title']])
@if ($errors->any())
<div class="alert alert-danger">
    Đã có lỗi xảy ra vui lòng kiểm tra lại..
</div>
@endif
<form action="{{route('post.destroy',$post->id)}}" class="box" method="post">
    @csrf
    @method('Delete')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p> - Thông tin nhóm bài viết bạn muốn xóa là : </p>
                        <p> - Lưu ý: Không thể khôi phục dữ liệu sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12   ">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">
                                        Tên nhóm bài viết <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{old('name',($post->name) ?? '')}} " class="form-control" placeholder="" autocomplete="off" readonly>
                                </div>
                                @error('name')
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
