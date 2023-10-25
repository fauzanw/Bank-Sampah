@push('scripts')
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
<script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
<script>
    @if($message = Session::get('error'))
        iziToast.error({
            title: 'Huft!',
            message: '{{ $message }}',
            position: 'topRight'
        });
    @elseif($message = Session::get('success'))
        iziToast.success({
        title: 'Yeayy!',
        message: '{{ $message }}',
        position: 'topRight'
        });
    @endif
</script>
@endpush