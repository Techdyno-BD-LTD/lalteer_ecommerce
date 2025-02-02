<a href="{{ route('compare') }}" class="d-flex align-items-center text-dark" data-toggle="tooltip"
    data-title="{{ translate('Compare') }}" data-placement="top">
    <span class="position-relative d-inline-block">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
            <path
                d="M16.042 11.9805V7.98047C16.042 5.77133 14.2511 3.98047 12.042 3.98047C9.83285 3.98047 8.04199 5.77133 8.04199 7.98047V11.9805M5.04199 9.98047H19.042L20.042 21.9805H4.04199L5.04199 9.98047Z"
                stroke="#1A1A1A" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @if (Session::has('compare'))
            <span
                class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count(Session::get('compare')) }}</span>
        @endif
    </span>
    <span class="pl-1">Cart</span>
</a>
