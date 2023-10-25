@extends('components.sidebar.base')

@section('menu')
    <li class="{{ url()->current() == route('dashboard') ? 'active' : '' }}">
        <a class="nav-link"
            href="{{ route('dashboard') }}"><i class="fas fa-fire">
            </i> <span>Dashboard</span>
        </a>
    </li>
@endsection