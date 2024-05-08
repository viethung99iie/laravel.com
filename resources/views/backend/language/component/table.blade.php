
<table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" class="form-check" id="checkAll" value="">
                </th>
                <th style="width: 100px;">Hình ảnh</th>
                <th class="text-center">Tên ngôn ngữ</th>
                <th class="text-center">Canonical</th>
                <th>Ghi chú</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody>
                @if (isset($languages) && is_object($languages))
                @foreach ($languages as $language)
                        <tr>
                <td>
                            <input type="checkbox" value="{{$language->id   }}" class="checkBoxItem" id='check' >

                </td>
                <td >
                    <span class="img-cover image "><img src="{{asset($language->image)}}" alt=""></span>
                </td>
                <td class="text-center">
                    <p>{{$language->name}}</p>
                </td>
                <td class="text-center">
                    <p>{{$language->canonical}}</p>
                </td>
                <td class="text-center">
                    <p>{{$language->description}}</p>
                </td>
                <td class="text-center">
                    <div class="ibox-content js-switch-{{$language->id}}">
                        <input
                        type="checkbox"
                        class="js-switch status"
                        data-model='language'
                        data-field='publish'
                        data-modelId = '{{$language->id}}'
                        value="{{$language->publish}}"
                        @checked($language->publish == 2)
                        />
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{route('language.edit',['id'=>$language->id] )}}" class="btn btn-success mx-2" > <i class="fa fa-edit"></i></a>
                    <a href="{{route('language.delete',$language->id )}}" class="btn btn-danger" > <i class="fa fa-trash"></i></a>
                </td>
            </tr>
                @endforeach
                @endif
            </tbody>
        </table>
{{$languages->links('pagination::bootstrap-4')}}




