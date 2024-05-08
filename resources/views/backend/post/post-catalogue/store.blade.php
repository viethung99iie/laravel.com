@include('backend.dashboard.component.breadcumb',['title'=>$config['seo'][$config['method']]['title']])
@php
    $form_action = ($config['method']=='edit') ? route('post.catalogue.update',['id'=>$postCatalogue->id]): route('post.catalogue.store');
@endphp
<form action="{{$form_action}}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin chung</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.post.post-catalogue.component.general')
                    </div>
                </div>
                @include('backend.dashboard.component.album')
                @include('backend.post.post-catalogue.component.seo')
            </div>
            <div class="col-lg-3">
                @include('backend.post.post-catalogue.component.aside')

            </div>
        </div>
        <div class="text-right mb15 btn-save">
            <button type="submit" class="btn btn-primary " value="send" name="send">Lưu Lại</button>
        </div>
    </div>
</form>

