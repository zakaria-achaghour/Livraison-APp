<table class="table table-respo has-checkbox align-middle table-row-bordered table-striped table-row-gray-300 fs-6 gy-5 datatable-browse" id="list">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th class="w-10px pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#list .form-check-input" value="1" />
                </div>
            </th>
            @foreach($columns as $column)
                @php
                	$column = $default_column + $column;
                @endphp

                @if($column['data'] == "checkbox")
                    @continue
                @endif

                @if($column['data'] == "action")
                	<th class="text-end min-w-70px">{{ $column['title'] }}</th>
                @elseif($column['visible'])
                	<th class="min-w-125px">{{ $column['title'] }}</th>
                @endif
            @endforeach
            
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
    </tbody>
</table>

@section('datatable_options')
<script type="text/javascript">
    $(document).ready(function() {
        // SEARCH
        $(".search-input").on('keyup', function (e) {
            if (e.keyCode === 13) {
                $('.placeholder-loader').addClass('holder-active');
                table.search($(this).val()).draw();
            }
        });

        // FILTER
        $('.btn-filter-apply').on('click', function(e) {
            e.preventDefault();
            $('.placeholder-loader').addClass('holder-active');
            table.draw();
        });

        $('.btn-filter-reset').on('click', function(e) {
            e.preventDefault();
            $('.filter-form input, .filter-form select').val("").trigger('change');
            //$('.form-select').val("").trigger('change');
            $('.placeholder-loader').addClass('holder-active');
            table.draw();
        });

        // RERESH
        $('.btn-refresh').on('click', function(e) {
            e.preventDefault();
            $('.placeholder-loader').addClass('holder-active');
            table.ajax.reload( null, false );
        });

        table.on('page.dt', function () {
            $('.placeholder-loader').addClass('holder-active');
        });

        table.on('length.dt', function () {
            $('.placeholder-loader').addClass('holder-active');
        });

        // Call the function on initial load and window resize
        addClassToRows();
        $(window).on('resize', addClassToRows);
    });

    // Add class to rows in mobile view
    function addClassToRows() {
        var screenWidth = $(window).width();
        var isMobileView = screenWidth < 768; // Adjust the breakpoint as needed
        
        table.rows().every(function () {
            var rowNode = this.node();
            if (isMobileView) {
                $(rowNode).addClass('placeholder-loader'); // Add your desired class name
            } else {
                $(rowNode).removeClass('placeholder-loader');
            }
        });
    }
</script>
@endsection