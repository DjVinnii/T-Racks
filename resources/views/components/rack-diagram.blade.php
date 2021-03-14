<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 10%;"></th>
        <th style="width: 20%;">@lang('app.front')</th>
        <th style="width: 50%;">@lang('app.interior')</th>
        <th style="width: 20%;">@lang('app.back')</th>
    </tr>
    </thead>
    <tbody>
    
    @for($i = $rack->height; $i > 0; $i--)
        <tr>
            <th>{{ $i }}</th>

{{--            TODO Fix multiple objects in rack unit--}}

            @php
                $rack_unit = $rack->rackUnits->where('unit_no', $i)->first();
            @endphp

            @if($rack_unit)
                @if($rack_unit->front == 1 && $rack_unit->interior == 1 && $rack_unit->back == 1)
                    <th colspan="3">{{ $rack_unit->hardware->name }}</th>
                @elseif($rack_unit->front == 1 && $rack_unit->interior == 1)
                    <th colspan="2">{{ $rack_unit->hardware->name }}</th>
                    <th></th>
                @elseif($rack_unit->interior == 1 && $rack_unit->back == 1)
                    <th></th>
                    <th colspan="2">{{ $rack_unit->hardware->name }}</th>
                @else
                    @if($rack_unit->front == 1)
                        <th>{{ $rack_unit->hardware->name }}</th>
                    @else
                        <th></th>
                    @endif

                    @if($rack_unit->interior == 1)
                        <th>{{ $rack_unit->hardware->name }}</th>
                    @else
                        <th></th>
                    @endif

                    @if($rack_unit->back == 1)
                        <th>{{ $rack_unit->hardware->name }}</th>
                    @else
                        <th></th>
                    @endif
                @endif
            @else
                <th></th>
                <th></th>
                <th></th>
            @endif
        </tr>
    @endfor
    </tbody>
</table>
