@php
    $permission = Auth::user()->getRoleNames()->toArray();
    $role = Auth::user()->hasRole('admin');
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span style="color: var(--bs-primary)">
                  <img width="50" height="50" src="{{asset('logo.png')}}" alt="logo">
                </span>
              </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2"> {{config('app.nama_instansi')}} </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                    fill="currentColor"
                    fill-opacity="0.6"/>
                <path
                    d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z"
                    fill="currentColor"
                    fill-opacity="0.38"/>
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ Request::is(['admin/data-siswa*'])  ? 'active' : '' }}">
            <a href="{{route('admin.data-siswa.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-team-line"></i>
                <div data-i18n="Notifikasi Whatsapp">Data Siswa</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is(['admin/notifikasi-whatsapp'])  ? 'active' : '' }}">
            <a href="{{route('admin.notifikasi-whatsapp.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-notification-badge-line"></i>
                <div data-i18n="Notifikasi Whatsapp">Notifikasi Whatsapp</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is(['admin/notifikasi-whatsapp-tagihan*'])  ? 'active' : '' }}">
            <a href="{{route('admin.notifikasi-whatsapp-tagihan.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-notification-line"></i>
                <div data-i18n="Notifikasi Whatsapp">Whatsapp Tagihan</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is(['admin/notifikasi-whatsapp-tunggakan*'])  ? 'active' : '' }}">
            <a href="{{route('admin.notifikasi-whatsapp-tunggakan.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-alarm-warning-line"></i>
                <div data-i18n="Notifikasi Whatsapp">Whatsapp Tunggakan</div>
            </a>
        </li>
      
        <li class="menu-item {{ Request::is(['admin/log-whatsapp*'])  ? 'active' : '' }}">
            <a href="{{route('admin.log-whatsapp.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-list-ordered"></i>
                <div data-i18n="Notifikasi Whatsapp">Log Whatsapp</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is(['admin/log-aktifitas*'])  ? 'active' : '' }}">
            <a href="{{route('admin.log-aktifitas.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-list-ordered"></i>
                <div data-i18n="Notifikasi Aktifitas">Log Aktifitas</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is(['admin/manajemen-user*'])  ? 'active' : '' }}">
            <a href="{{route('admin.manajemen-user.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri ri-admin-line"></i>
                <div data-i18n="Manajemen User">Manajemen User</div>
            </a>
        </li>
    </ul>
</aside>
