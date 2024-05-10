<form action="{{ route('post.catalogue.index') }}">
    <div class="filter-wapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                @php
                $perpage = Request('perpage') ?: old('perpage');
                @endphp
                <div class="uk-flex uk-flex-middle uk-flex-space-between ">
                    <select id="records" name="perpage" class="form-control filter mr10">
                        @for ($i = 20; $i <= 200; $i +=20) <option value="{{ $i }}" @selected($perpage==$i)>
                            {{ $i }} {{__('messages.perpage')}}

                            </option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="action">
                @php
                $publishArr = ['Chưa kích hoạt', 'Đã kích hoạt'];

                $publish = Request('publish') ?: old('publish');
                @endphp
                <div class="uk-flex uk-flex-middle ">
                    <div class="uk-flex uk-flex-middle  mr10 ">
                        <select name="publish" class="form-control setUpSelect2">
                            @foreach (__('messages.publish') as $key => $val)
                            <option @selected($publish==$key) value="{{ $key }}">
                                {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-flex uk-flex-middle mr-10">
                        <div class="input-group">
                            <input type="text" name="keywords" value="{{ request('keywords') ?: old('keywords') }}" placeholder="{{__('messages.searchInput')}}" class="form-control">

                            <span class="input-group-btn">
                                <button type="submit" name="search" value="search" class="btn btn-primary mb-0 btn-sm mr10">{{__('messages.search')}}</button>

                            </span>
                        </div>
                    </div>
                    <a href="{{ route('post.catalogue.create') }}" class="btn btn-warning"><i class="fa fa-plus mr5">
                            <span>{{ __('messages.postCatalogue.create.title') }}</span></i></a>
                </div>
            </div>
        </div>
    </div>

</form>
