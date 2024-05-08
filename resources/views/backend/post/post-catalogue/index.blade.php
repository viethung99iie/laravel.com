
@include('backend.dashboard.component.breadcumb',['title'=>$config['seo']['index']['title']])
<div class="row mt20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{$config['seo']['index']['table']}}</h5>
                    @include('backend.post.post-catalogue.component.tool', ['model' => 'PostCatalogue'])
                </div>
                <div class="ibox-content">
                    @include('backend.post.post-catalogue.component.filter',['title'=>$config['seo']['create']['title']])
                    @include('backend.post.post-catalogue.component.table')
                </div>
            </div>
        </div>
</div>
