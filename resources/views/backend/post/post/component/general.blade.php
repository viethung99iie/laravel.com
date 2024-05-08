<div class="row mb15">
    <div class="col-lg-12">
        <label for="" class="control-label text-left">
                Tiêu đề nhóm bài viết<span class="text-danger">(*)</span>
        </label>
        <input
                type="text"
                name="name"
                value="{{old('name',($post->name) ?? '')}} "
                class="form-control"
                autocomplete="off"
            >
    </div>
    @error('name')
        <div class="error-message">* {{ $message }}</div>
    @enderror
</div>
<div class="row mb15">
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
            >{!!old('description',($post->description) ?? '')!!} </textarea>
    </div>
    @error('description')
        <div class="error-message">* {{ $message }}</div>
    @enderror
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <label for="" class="control-label text-left">
                Nội dung<span class="text-danger">(*)</span>
        </label>
        <textarea
                type="text"
                name="content"
                value=""
                class="form-control ck-editor"
                id= 'content'
                autocomplete="off"
                data-height= "400"
            >{!!old('content',($post->content) ?? '')!!} </textarea>
    </div>
    @error('content')
        <div class="error-message">* {{ $message }}</div>
    @enderror
</div>
