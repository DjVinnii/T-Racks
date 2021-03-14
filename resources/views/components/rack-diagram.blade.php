{{ App\Helpers\RackHelper::markAllSpans($rack) }}

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

    @for($i = $rack->height; $i > 0; $i--)  {{-- Loop Height --}}
        <tr>
            <th>{{ $i }}</th>

            @php
                for ($locidx = 0; $locidx < 3; $locidx++) // Loop front, interior, back
                {
                    $rack_unit = $rack->rackUnits->where('unit_no', $i)->where('position', $locidx)->first();

                    if(isset($rack_unit->skipped))
                        continue;

                    echo '<td class="text-center"';

                    if (isset($rack_unit->colspan))
                        echo ' colspan=' . $rack_unit->colspan;
                    if (isset($rack_unit->rowspan))
                        echo ' rowspan=' . $rack_unit->rowspan;

                    echo '>';
                    if (isset($rack_unit->hardware->name))
                        echo '<a href="' .  route('hardware.show', $rack_unit->hardware)  .'">' . $rack_unit->hardware->name . '</a>';
                    echo '</td>';
                }
            @endphp
        </tr>
    @endfor
    </tbody>
</table>
