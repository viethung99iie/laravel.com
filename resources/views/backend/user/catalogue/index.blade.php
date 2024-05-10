
@include('backend.dashboard.component.breadcumb',['title'=>$config['seo']['index']['title']])
<div class="row mt20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{$config['seo']['index']['table']}}</h5>
                    @include('backend.user.catalogue.component.tool', ['model' => 'UserCatalogue'])
                </div>
                <div class="ibox-content">
                    @include('backend.user.catalogue.component.filter',['title'=>$config['seo']['create']['title']])
                    @include('backend.user.catalogue.component.table')
                </div>
            </div>
        </div>
</div>
