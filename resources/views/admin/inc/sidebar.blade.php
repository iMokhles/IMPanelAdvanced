@if (Auth::guard('admin')->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('admin.inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          <!-- ======================================= -->
           <li class="header">System</li>

              <li><a href='{{ backpack_url('/backup') }}'><i class='fa fa-hdd-o'></i> <span>Backups</span></a></li>
              <li><a href='{{ backpack_url('/log') }}'><i class='fa fa-terminal'></i> <span>Logs</span></a></li>
              <li><a href="{{ backpack_url('/page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
              <li><a href="{{ backpack_url('/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>
              <li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
              <li><a href='{{ backpack_url('/setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
