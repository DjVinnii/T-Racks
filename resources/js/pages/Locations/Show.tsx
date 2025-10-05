import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import LocationApiRoutes from '@/routes/api/locations';
import RackApiRoutes from '@/routes/api/racks';
import LocationRoutes from '@/routes/locations';
import { type BreadcrumbItem, type Location, type Rack } from '@/types';
import { Head } from '@inertiajs/react';
import { useQuery } from '@tanstack/react-query';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Locations', href: LocationRoutes.index.url() },
    { title: 'Location', href: '#' },
];

export default function LocationShow({ location }: { location: string }) {
    const { data, isLoading } = useQuery({
        queryKey: ['location', location],
        queryFn: async () => {
            const resp = await axios.get(LocationApiRoutes.show.url(location), {
                withCredentials: true,
            });
            return resp.data.data ?? resp.data;
        },
    });

    const details = data as Location | null;

    const racksQuery = useQuery({
        queryKey: ['location-racks', location],
        queryFn: async () => {
            const resp = await axios.get(
                RackApiRoutes.index.url({
                    query: { location_id: location, per_page: 100 },
                }),
                { withCredentials: true },
            );
            const json = resp.data;
            if (json && json.data) return json.data;
            if (Array.isArray(json)) return json;
            return [];
        },
    });

    const racks = racksQuery.data ?? ([] as Rack[]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Location: ${details?.name ?? 'Loading...'}`} />

            <div className="p-4">
                <div className="rounded-md border p-4">
                    <div className="text-sm text-muted-foreground">Name</div>
                    <div className="text-xl font-semibold">{details?.name}</div>
                    <div className="text-xs text-muted-foreground">
                        ID: {details?.id}
                    </div>
                </div>

                <div className="mt-4">
                    <div className="text-lg font-medium">Assigned Racks</div>
                    <div className="mt-2 space-y-2">
                        {racks.length === 0 ? (
                            <div className="text-sm text-muted-foreground">
                                No racks assigned
                            </div>
                        ) : (
                            racks.map((r: Rack) => (
                                <div
                                    key={r.id}
                                    className="flex items-center justify-between rounded-md border p-3"
                                >
                                    <div>
                                        <div className="text-sm font-medium">
                                            {r.name}
                                        </div>
                                        <div className="text-xs text-muted-foreground">
                                            {r.created_at}
                                        </div>
                                    </div>
                                    <div>
                                        <Button size="sm">View</Button>
                                    </div>
                                </div>
                            ))
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
