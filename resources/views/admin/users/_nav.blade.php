<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.home') }}">{{ __('Dashboard') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.regions.index') }}">{{ __('Regions') }}</a></li>
    <li class="nav-item"><a class="nav-link"
                            href="{{ route('admin.adverts.categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
</ul>