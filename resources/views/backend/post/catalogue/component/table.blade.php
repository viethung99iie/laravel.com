<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 50px">
                <input type="checkbox" class="form-check" id="checkAll" value="">
            </th>
            <th>{{__('messages.tableName')}}</th>
            @include('backend.dashboard.component.languageTh')
            <th class="text-center" style="width: 100px">{{__('messages.tableStatus')}}</th>

            <th class="text-center" style="width: 100px">{{__('messages.tableAction')}}</th>

        </tr>
    </thead>
    <tbody>
        @if (isset($postCatalogues) && is_object($postCatalogues))
        @foreach ($postCatalogues as $postCatalogue)
        <tr>
            <td>
                <input type="checkbox" value="{{$postCatalogue->id}}" class="checkBoxItem" id='check'>
            </td>
            <td>
                <p class="info-item name">
                    {{str_repeat('|-----', (($postCatalogue->level > 0)?($postCatalogue->level - 1):0)).$postCatalogue->name}}</p>
            </td>
            @include('backend.dashboard.component.languageTd',['model'=>($postCatalogue),'modeling'=> 'PostCatalogue'])
            <td class="text-center">
                <div class="ibox-content js-switch-{{$postCatalogue->id}}">
                    <input type="checkbox" class="js-switch status" data-model='{{ $config['model']}}' data-field='publish' data-modelId='{{$postCatalogue->id}}' value="{{$postCatalogue->publish}}" @checked($postCatalogue->publish == 2 )
                    />
                </div>
            </td>
            <td class="text-center">
                <a href="{{route('post.catalogue.edit',['id'=>$postCatalogue->id] )}}" class="btn btn-success mx-2 d-inline"> <i class="fa fa-edit"></i></a>
                <a href="{{route('post.catalogue.delete',$postCatalogue->id )}}" class="btn btn-danger"> <i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{$postCatalogues->links('pagination::bootstrap-4')}}
