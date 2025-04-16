@extends('layouts.app-master')

@section('content')
    @include('home.post.sessions.user')
    @include('home.post.sessions.guest')
@endsection

<script src="{{ asset('js/like-button.js') }}"></script>
<script>
    function scrollToDescription() {
        const descriptionSection = document.getElementById('description-section');
        const navbar = document.querySelector('nav.navbar');
        const navbarHeight = navbar ? navbar.offsetHeight : 0;
        const offsetPosition = descriptionSection.offsetTop - navbarHeight - 20;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
</script>
