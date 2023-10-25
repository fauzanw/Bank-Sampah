@extends('components.sidebar.base')

@section('menu')
    <li class="{{ url()->current() == route('admin.index') ? 'active' : '' }}">
        <a class="nav-link"
            href="{{ route('admin.index') }}"><i class="fas fa-fire">
            </i> <span>Dashboard</span>
        </a>
    </li>
    <li class="{{ url()->current() == route('admin.master_jenis_sampah') ? 'active' : '' }}">
        <a class="nav-link"
            href="{{ route('admin.master_jenis_sampah') }}"><i class="fas fa-boxes-stacked">
            </i> <span>Master Jenis Sampah</span>
        </a>
    </li>
    <li>
        <a class="nav-link"
            href="{{ route('auth.logout') }}"><i class="fas fa-sign-out">
            </i> <span>Logout</span>
        </a>
    </li>
@endsection