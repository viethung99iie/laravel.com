@include('backend.dashboard.component.breadcumb',['title'=>$config['seo']['delete']['title']])
@if ($errors->any())
<div class="alert alert-danger">
    {{__('messages.error')}}
</div>
@endif
<form action="{{route('post.catalogue.destroy',$postCatalogue->id)}}" class="box" method="post">
    @csrf
    @method('Delete')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">{{__('messages.generalTitle')}}</div>

                    <div class="panel-description">
                        {{__('messages.generalDescription')}}

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
                                        {{__('messages.title')}} <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="name" value="{{old('name',($postCatalogue->name) ?? '')}} " class="form-control" placeholder="" autocomplete="off" readonly>
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
