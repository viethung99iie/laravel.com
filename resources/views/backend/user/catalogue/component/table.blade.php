<table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" class="form-check" id="checkAll" value="">
                </th>
                <th>Thông tin nhóm thành viên</th>
                <th class="text-center"> Số lượng</th>
                <th style="width: 40%;">Ghi chú</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody>
                @if (isset($userCatalogues) && is_object($userCatalogues))
                @foreach ($userCatalogues as $userCatalogue)
                        <tr>
                <td>
                    <input
                        type="checkbox"
                        value="{{$userCatalogue->id}}"
                        class="checkBoxItem"
                        id='check'
                    >
                </td>
                <td>
                    <p class="info-item name">{{$userCatalogue->name}}</p>
                </td>
                <td class=" text-center">
                    <p class="info-item quantity">{{$userCatalogue->users_count}} người</p>
                </td>
                <td>
                    <p class="info-item description">{{$userCatalogue->description}}</p>
                </td>
                <td class="text-center">
                    <div class="ibox-content js-switch-{{$userCatalogue->id}}">
                        <input
                            type="checkbox"
                            class="js-switch status"
                            data-model='{{ $config['model']}}'
                            data-field='publish'
                            data-modelId = '{{$userCatalogue->id}}'
                            value="{{$userCatalogue->publish}}"
                            @checked($userCatalogue->publish == 2   )
                        />
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{route('user.catalogue.edit',['id'=>$userCatalogue->id] )}}" class="btn btn-success mx-2 d-inline" > <i class="fa fa-edit"></i></a>
                    <a href="{{route('user.catalogue.delete',$userCatalogue->id )}}" class="btn btn-danger" > <i class="fa fa-trash"></i></a>
                </td>
            </tr>
                @endforeach
                @endif
            </tbody>
        </table>
{{$userCatalogues->links('pagination::bootstrap-4')}}


