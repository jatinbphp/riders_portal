<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link" wire:navigate>
      <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
               
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" wire:navigate>
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(auth()->user()->role === 'super_admin')
                    <li class="nav-item"><a href="{{ route('athlete') }}" class="nav-link {{ request()->is('athlete') ? 'active' : '' }}" wire:navigate>
                    <i class="nav-icon fas fa-biking"></i>
                        <p>Manage Athletes</p>
                    </a></li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}" wire:navigate>
                        <i class="nav-icon fas fa-file"></i>
                        <p>Profile Management</p>
                    </a>
                </li>     
                @if(auth()->check() && auth()->user()->role === 'super_admin')
                <li class="nav-item">
                    <a href="{{ route('clubs') }}" class="nav-link {{ request()->is('manage-clubs') ? 'active' : '' }}" wire:navigate>
                        <i class="nav-icon fa fa-clipboard"></i>
                        <p>Clubs</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('social-links') }}" class="nav-link {{ request()->is('social-links') ? 'active' : '' }}" wire:navigate>
                        <i class="nav-icon fa fa-clipboard"></i>
                        <p>Social Links</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('uploads') }}" class="nav-link {{ request()->is('manage-uploads') ? 'active' : '' }}" wire:navigate>
                        <i class="nav-icon fa fa-upload"></i>
                        <p>Uploads</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('document.uploads') }}" class="nav-link {{ request()->is('document-uploads') ? 'active' : '' }}" wire:navigate>
                        <i class="nav-icon fa fa-file-pdf"></i>
                        <p>Document Uploads</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" wire:click="logout">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li> 
            </ul>
        </nav>
    </div>
</aside>
