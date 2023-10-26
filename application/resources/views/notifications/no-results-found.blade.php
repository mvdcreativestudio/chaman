<div class="page-notification">
    <img src="{{ url('/') }}/public/images/no-results-found.png" alt="404" /> 
    @if (isset($page['no_results_message']) && $page['no_results_message'])
    <!--sepcified-->
    <div class="">{{ $page['no_results_message'] ?? '' }}</div>
    @else
    <!--generic-->
    <div class="">{{ cleanLang(__('lang.no_results_found')) }}</div>
    @endif 
    {{-- @if (isset($page['no_results_sub_message']) && $page['no_results_sub_message'])
    <!--sepcified-->
    <div class="sub-title">{{ $page['no_results_sub_message'] ?? '' }}</div>
    @else
    <!--generic-->
    <div class="sub-title">{{ cleanLang(__('lang.try_a_differet_search')) }}</div>
    @endif --}}
</div>