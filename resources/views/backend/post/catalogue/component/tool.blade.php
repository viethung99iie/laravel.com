<div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-wrench"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a  class="changeStatusAll" data-model="{{ $config['model'] }}" data-field="publish" data-value='2'>Publish tất cả</a>
                </li>
                <li><a class="changeStatusAll" data-model="{{ $config['model'] }}" data-field="publish" data-value='1'>Unpublish tất cả</a>
                </li>
            </ul>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
</div>