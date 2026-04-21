@if(env('CLIENT_NAME') == 'vsc')
    <img src="{{ asset('images/logo/vsc_logo.png') }}" alt="VSC Solutionsn Logo" class="w-8 0 h-20">
@else
    <img src="{{ asset('images/logo/latin_logo.jpeg') }}" alt="Latin Electrical Logo" class="w-80 h-20">
@endif