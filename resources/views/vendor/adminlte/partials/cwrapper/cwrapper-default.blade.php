@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

{{-- Default Content Wrapper --}}
<div class="content-wrapper {{ config('adminlte.classes_content_wrapper', '') }}">

    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="content">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-double"></i>      {{ session('success') }}
                </div> 
            @endif

            @if(session('error-message'))
                <div class="alert alert-danger">
                    <i class="fa fa-bug"></i>      {{ session('error-message') }}
                </div> 
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa fa-bug"></i>      {{ session('error') }}
                </div> 
            @endif
            @yield('content')
        </div>
    </div>

</div>
