@include('backend.dashboard.component.breadcrumb',['title'=>$config['seo'][$config['method']]['title']])
@php
$form_action = ($config['method']=='edit') ? route('post.catalogue.update',['id'=>$post->id]): route('post.catalogue.store');
@endphp
<form action="{{$form_action}}" class="box" method="post">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('messages.generalTitle')}}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content',['model'=>($post) ?? null])
                    </div>
                </div>
                @include('backend.dashboard.component.album')
                @include('backend.dashboard.component.seo',['model'=>($post)?? null])
            </div>
            <div class="col-lg-3">
                @include('backend.post.catalogue.component.aside')

            </div>
        </div>
        <div class="text-right mb15 btn-save">
            <button type="submit" class="btn btn-primary " value="send" name="send">Lưu Lại</button>
        </div>
    </div>
</form>
