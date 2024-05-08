<table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th style="width: 50px">
                    <input type="checkbox" class="form-check" id="checkAll" value="">
                </th>
                <th>Tên nhóm bài viết</th>
                <th class="text-center" style="width: 100px">Trạng thái</th>
                <th class="text-center" style="width: 100px">Thao tác</th>
            </tr>
            </thead>
            <tbody>
                @if (isset($posts) && is_object($posts))
                @foreach ($posts as $post)
                        <tr>
                <td>
                    <input
                        type="checkbox"
                        value="{{$post->id}}"
                        class="checkBoxItem"
                        id='check'
                    >
                </td>
                <td>
                    <p class="info-item name">
                        {{str_repeat('|-----', (($post->level > 0)?($post->level - 1):0)).$post->name}}</p>
                </td>
                <td class="text-center">
                    <div class="ibox-content js-switch-{{$post->id}}">
                        <input
                            type="checkbox"
                            class="js-switch status"
                            data-model='Post'
                            data-field='publish'
                            data-modelId = '{{$post->id}}'
                            value="{{$post->publish}}"
                            @checked($post->publish == 2   )
                        />
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{route('post.edit',['id'=>$post->id] )}}" class="btn btn-success mx-2 d-inline" > <i class="fa fa-edit"></i></a>
                    <a href="{{route('post.delete',$post->id )}}" class="btn btn-danger" > <i class="fa fa-trash"></i></a>
                </td>
            </tr>
                @endforeach
                @endif
            </tbody>
        </table>
{{$posts->links('pagination::bootstrap-4')}}


