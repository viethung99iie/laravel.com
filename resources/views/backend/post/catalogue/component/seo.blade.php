<div class="ibox">
    <div class="ibox-title">
        <h5>{{__('messages.seo')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="seo-container">
            <h3 class="meta-title">
                {{old('meta_title',(isset($post->meta_title) ?$post->meta_title : __('messages.seoTitle')))}}
            </h3>
            <div class="meta-canonical">
                {{old('canonical',
                                (isset($post->canonical) ? config('app.url').'/'.$post->canonical.config('apps.general.suffix') : __('messages.seoCanonical')))}}



            </div>
            <div class="meta-description">
                {{old('meta_title',(isset($post->meta_description) ?$post->meta_description : __('messages.seoDescription')))}}


            </div>
        </div>
        <div class="seo-wrapper">
            <div class="row mb15">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span>{{__('messages.seoMetaTitle')}}</span>


                                <span class="count_meta-title">0 {{__('messages.character')}}</span>

                            </div>
                        </label>
                        <input type="text" name="meta_title" value="{{old('meta_title',($post->meta_title) ?? '')}} " class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            {{__('messages.seoMetaKeyword')}}

                        </label>
                        <input type="text" name="meta_keyword" value="{{old('meta_keyword',($post->meta_keyword) ?? '')}} " class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span>{{__('messages.seoMetaDescription')}}</span>

                                <span class="count_meta-description">0 {{__('messages.character')}}</span>

                            </div>
                        </label>
                        <textarea name="meta_description" class="form-control" autocomplete="off">{!!old('meta_description',($post->meta_description) ?? '')!!} </textarea>
                    </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                    <div class="form-row">
                        <label for="" class="control-label text-left">
                            {{__('messages.canonical')}}<span class="text-danger">(*)</span>

                        </label>
                        <div class="input-wrapper">
                            <input type="text" name="canonical" value="{{old('canonical',($post->canonical) ?? '')}} " class="form-control" autocomplete="off">
                            <span class="baseUrl">{{config('app.url')}}/</span>
                        </div>
                    </div>
                    @error('canonical')
                    <div class="error-message">* {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
