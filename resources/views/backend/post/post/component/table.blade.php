<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 50px">
                <input type="checkbox" class="form-check" id="checkAll" value="">
            </th>
            <th>{{__('messages.tableName')}}</th>

            <th style="width:80px;" class="text-center">{{__('messages.tableOrder')}}</th>

            <th class="text-center" style="width: 100px">{{__('messages.tableStatus')}}</th>

            <th class="text-center" style="width: 100px">{{__('messages.tableAction')}}</th>

        </tr>
    </thead>
    <tbody>
        @if (isset($posts) && is_object($posts))
        @foreach ($posts as $post)
        <tr>
            <td>
                <input type="checkbox" value="{{ $post->id }}" class="checkBoxItem" id='check'>
            </td>
            <td>
                <div class="uk-flex uk-flex-middle">
                    <div class="image mr5">
                        <div class="img-cover image-post" style="width: 90px;height: 60px;"><img src="{{ $post->image }}" alt=""></div>
                    </div>
                    <div class="main-info">
                        <div class="name"><span class="maintitle">{{ $post->name
                                }}</span>
                        </div>
                        <div class="catalogue">
                            <span class="text-danger">{{__('messages.tableGroup')}}
                            </span>
                            @foreach ($post->post_catalogues as $val)
                            @foreach ($val->post_catalogue_language as $cat)
                            <a href="{{ route('post.index', ['post_catalogue_id' => $val->id]) }}" title="">{{ $cat->name }}</a>
                            @endforeach
                            @endforeach
                        </div>

                    </div>
                </div>
            </td>
            <td>
                <input type="text" name="order" value="{{ $post->order }}" class="form-control sort-order text-right" data-id="{{ $post->id }}" data-model="{{ $config['model'] }}">
            </td>
            <td class="text-center">
                <div class="ibox-content js-switch-{{ $post->id }}">
                    <input type="checkbox" class="js-switch status" data-model="{{ $config['model'] }}" data-field='publish' data-modelId='{{ $post->id }}' value="{{ $post->publish }}" @checked($post->publish ==
                    2) />
                </div>
            </td>
            <td class="text-center">
                <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="btn btn-success mx-2 d-inline"> <i class="fa fa-edit"></i></a>
                <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger"> <i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{ $posts->links('pagination::bootstrap-4') }}
