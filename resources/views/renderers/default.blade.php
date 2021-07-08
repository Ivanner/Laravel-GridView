@php
/**
* @var \Woo\GridView\GridView $grid
**/
    $paginator = $grid->getPagination();
    $thisStart = 1 + ($paginator->currentPage() - 1) * $paginator->perPage();
    $thisEnd = $paginator->currentPage() * $paginator->perPage()
@endphp

<div class="grid-view-container"
     id="grid-{{ $grid->getId() }}">
    <grid-view
        :origin-filters='@json($filters)'
        sort-column="{{ $grid->getRequest()->sortColumn }}"
        sort-order="{{ $grid->getRequest()->sortOrder }}"
        :ajax-update="{{ $grid->ajaxUpdate?"true":"false" }}"
        target-url="{{ $grid->targetUrl }}"
        :enable-pagination="{{ $grid->enablePagination?"true":"false" }}"
    >


    </grid-view>
</div>

@if ($grid->standaloneVue)
<script src="{{ asset('vendor/grid-view/grid-view.bundle.js')  }}"></script>
<script>
    window.GridViewShared = @json([]);
    new WooGridView('#grid-{{ $grid->getId() }}');
</script>
@endif
