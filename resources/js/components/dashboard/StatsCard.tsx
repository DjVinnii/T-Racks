import { useQuery } from '@tanstack/react-query';
import axios from 'axios';
import { ChartContainer, ChartTooltip } from '@/components/ui/chart';
import { LineChart, Line, XAxis, YAxis } from 'recharts';

type Series = {
    labels: string[];
    locations: number[];
    racks: number[];
};

type StatsResponse = { totals: { locations: number; racks: number }; series: Series };

function useStats() {
    const { data, isLoading } = useQuery({
        queryKey: ['stats'],
        queryFn: async (): Promise<StatsResponse> => {
            const resp = await axios.get('/api/stats', { withCredentials: true });
            return resp.data as StatsResponse;
        },
    });

    return { data, isLoading };
}

function Sparkline({ values, labels }: { values: number[]; labels: string[] }) {
    const data = labels.map((label, i) => ({ day: label, value: values[i] ?? 0 }));

    return (
        <ChartContainer id="sparkline" className="w-full" style={{ minHeight: 64 }} config={{}}>
            <LineChart data={data} margin={{ top: 2, right: 8, left: 0, bottom: 2 }}>
                <XAxis dataKey="day" hide />
                <YAxis hide domain={[0, 'dataMax']} />
                <ChartTooltip />
                <Line type="monotone" dataKey="value" stroke="currentColor" strokeWidth={2} dot={false} />
            </LineChart>
        </ChartContainer>
    );
}

export function LocationsStats() {
    const { data, isLoading } = useStats();

    if (isLoading || !data) {
        return (
            <div className="rounded-xl border p-4">
                <div className="text-sm text-muted-foreground">Loading stats...</div>
            </div>
        );
    }

    return (
        <div className="rounded-xl border p-4">
            <div className="flex items-center justify-between">
                <div>
                    <div className="text-xs text-muted-foreground">Locations</div>
                    <div className="text-2xl font-semibold">{data.totals.locations}</div>
                </div>
                <div className="text-muted-foreground"><Sparkline values={data.series.locations} labels={data.series.labels} /></div>
            </div>
        </div>
    );
}

export function RacksStats() {
    const { data, isLoading } = useStats();

    if (isLoading || !data) {
        return (
            <div className="rounded-xl border p-4">
                <div className="text-sm text-muted-foreground">Loading stats...</div>
            </div>
        );
    }

    return (
        <div className="rounded-xl border p-4">
            <div className="flex items-center justify-between">
                <div>
                    <div className="text-xs text-muted-foreground">Racks</div>
                    <div className="text-2xl font-semibold">{data.totals.racks}</div>
                </div>
                <div className="text-muted-foreground"><Sparkline values={data.series.racks} labels={data.series.labels} /></div>
            </div>
        </div>
    );
}