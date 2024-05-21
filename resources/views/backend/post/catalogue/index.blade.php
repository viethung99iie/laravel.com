@include('backend.dashboard.component.breadcrumb',['title'=>__('messages.postCatalogue.index.title')])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{__('messages.postCatalogue.index.table')}}</h5>
                @include('backend.post.catalogue.component.tool', ['model' => 'PostCatalogue'])
            </div>
            <div class="ibox-content">
                @include('backend.post.catalogue.component.filter',['title'=>__('messages.post.create.title')])
                @include('backend.post.catalogue.component.table')
            </div>
        </div>
    </div>
</div>
