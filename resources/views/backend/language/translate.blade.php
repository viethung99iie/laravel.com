@include('backend.dashboard.component.breadcrumb',['title'=>$config['seo']['translate']['title']])
@include('backend.dashboard.component.formError')
<form action="{{route('language.storeTranslate')}}" class="box" method="post">
    @csrf
    <input type="hidden" name="option[id]" value="{{ $option['id'] }}">
    <input type="hidden" name="option[languageId]" value="{{ $option['languageId'] }}">
    <input type="hidden" name="option[model]" value="{{ $option['model'] }}">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('messages.generalTitle')}}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content',['model' => ($object) ?? null, 'disabled' => 1])


                    </div>
                </div>
                @include('backend.dashboard.component.seo',['model' => ($object) ?? null, 'disabled' => 1])

            </div>
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.tableHeading') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.translate', ['model' => ($objectTransate) ?? null])
                    </div>
                </div>
                @include('backend.dashboard.component.seoTranslate', ['model' => ($objectTransate) ?? null])
            </div>
        </div>
        <div class="text-right mb15 btn-save">
            <button type="submit" class="btn btn-primary " value="send" name="send">Lưu Lại</button>
        </div>
    </div>
</form>
