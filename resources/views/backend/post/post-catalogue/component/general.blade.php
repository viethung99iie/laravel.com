<div class="row mb15">
    <div class="col-lg-12">
        <label for="" class="control-label text-left">
                Tiêu đề nhóm bài viết<span class="text-danger">(*)</span>
        </label>
        <input
                type="text"
                name="name"
                value="{{old('name',($postCatalogue->name) ?? '')}} "
                class="form-control"
                autocomplete="off"
            >
    </div>
    @error('name')
        <div class="error-message">* {{ $message }}</div>
    @enderror
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <label for="" class="control-label text-left">
                Mô tả ngắn<span class="text-danger">(*)</span>
        </label>
        <textarea
                name="description"
                class="form-control ck-editor"
                id= 'description'
                autocomplete="off"
                data-height= "150"
            >{!!old('description',($postCatalogue->description) ?? '')!!} </textarea>
    </div>
    @error('description')
        <div class="error-message">* {{ $message }}</div>
    @enderror
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <label for="" class="control-label text-left">
                Nội dung<span class="text-danger">(*)</span>
            </label>
            <a href="" class="multipleUploadImageCkeditor" data-target='ckContent'>Upload nhiều hình ảnh</a>
        </div>

        <textarea
                type="text"
                name="content"
                value=""
                class="form-control ck-editor"
                id= 'ckContent'
                autocomplete="off"
                data-height= "400"
            >{!!old('content',($postCatalogue->content) ?? '')!!} </textarea>
    </div>
    @error('content')
        <div class="error-message">* {{ $message }}</div>
    @enderror
</div>
