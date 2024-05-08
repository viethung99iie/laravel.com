<table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" class="form-check" id="checkAll" value="">
                </th>
                <th style="width: 113px;">Avatar</th>
                <th>Thông tin người dùng</th>
                <th>Địa chỉ</th>
                <th class="text-center">Tên nhóm thành viên</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody>
                @if (isset($users) && is_object($users))
                @foreach ($users as $user)
                        <tr>
                <td>
                            <input type="checkbox" value="{{$user->id   }}" class="checkBoxItem" id='check' >

                </td>
                <td >
                    <span class="img-cover image "><img src="{{asset($user->image)}}" alt=""></span>
                </td>
                <td>
                    <p><strong>Họ và tên</strong>: {{$user->name}}</p>
                    <p><strong>Email</strong>: {{$user->email}}</p>
                    <p><strong>Phone</strong>: {{$user->phone}} </p>
                </td>
                <td>
                    <p><strong>Địa chỉ</strong>: 470 trần đại nghĩa</p>
                    <p><strong>Xã/Phường</strong>: Hòa quý</p>
                    <p><strong>Huyện/Quận</strong>: Ngũ Hành Sơn</p>
                    <p><strong>Tỉnh/Thành phố</strong>: Đà Nẵng</p>
                </td>
                <td class="text-center">
                    {{$user->user_catalogues->name}}
                </td>
                <td class="text-center">
                    <div class="ibox-content js-switch-{{$user->id}}">
                        <input
                        type="checkbox"
                        class="js-switch status"
                        data-model='user'
                        data-field='publish'
                        data-modelId = '{{$user->id}}'
                        value="{{$user->publish}}"
                        @checked($user->publish == 2)
                        />
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{route('user.edit',['id'=>$user->id] )}}" class="btn btn-success mx-2" > <i class="fa fa-edit"></i></a>
                    <a href="{{route('user.delete',$user->id )}}" class="btn btn-danger" > <i class="fa fa-trash"></i></a>
                </td>
            </tr>
                @endforeach
                @endif
            </tbody>
        </table>
{{$users->links('pagination::bootstrap-4')}}
