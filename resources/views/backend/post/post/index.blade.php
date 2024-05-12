@include('backend.dashboard.component.breadcumb',['title'=>__('messages.post.index.title')])


<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('messages.post.index.table')}}</h5>

                @include('backend.post.post.component.tool', ['model' => 'Post'])
            </div>
            <div class="ibox-content">
                @include('backend.post.post.component.filter',['title'=>__('messages.post.create.title')])

                @include('backend.post.post.component.table')
            </div>
        </div>
    </div>
</div>
