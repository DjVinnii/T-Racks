import DeviceDialog from '@/components/devices/DeviceDialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import DeviceApiRoutes from '@/routes/api/devices';
import RackApiRoutes from '@/routes/api/racks';
import { type BreadcrumbItem, type Device, type Rack } from '@/types';
import { Head } from '@inertiajs/react';
import {
    keepPreviousData,
    useMutation,
    useQuery,
    useQueryClient,
} from '@tanstack/react-query';
import axios from 'axios';
import { useState } from 'react';
import { toast } from 'sonner';

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Devices', href: '/devices' }];

export default function DevicesIndex() {
    const [query, setQuery] = useState('');
    const [page, setPage] = useState(1);
    const [perPage] = useState(15);
    const [createOpen, setCreateOpen] = useState(false);
    const [editOpen, setEditOpen] = useState(false);
    const [deleteOpen, setDeleteOpen] = useState(false);
    const [deletingId, setDeletingId] = useState<string | null>(null);
    const [deletingName, setDeletingName] = useState('');
    const [editingId, setEditingId] = useState<string | null>(null);
    const [editingName, setEditingName] = useState('');
    const [editingRackId, setEditingRackId] = useState<string | null>(null);
    const [createErrors, setCreateErrors] = useState<Record<string, string[]>>(
        {},
    );

    const queryClient = useQueryClient();

    const racksQuery = useQuery<Rack[]>({
        queryKey: ['racks', { per_page: 100 }],
        queryFn: async () => {
            const url = RackApiRoutes.index.url({ query: { per_page: 100 } });
            const resp = await axios.get(url, { withCredentials: true });
            return resp.data.data ?? resp.data;
        },
    });

    const racks = racksQuery.data ?? [];

    const listQuery = useQuery<{ items: Device[]; meta: any }>({
        queryKey: ['devices', { page, perPage, query }],
        queryFn: async () => {
            const url = DeviceApiRoutes.index.url({
                query: { page, per_page: perPage, name: query },
            });
            const resp = await axios.get(url, {
                headers: { Accept: 'application/json' },
                withCredentials: true,
            });
            const json = resp.data;

            if (json && json.data) {
                return { items: json.data, meta: json.meta ?? null };
            }

            if (Array.isArray(json)) {
                return { items: json, meta: null };
            }

            return { items: [], meta: null };
        },
        placeholderData: keepPreviousData,
    });

    const items = listQuery.data?.items ?? [];
    const meta = listQuery.data?.meta ?? null;

    const createMutation = useMutation({
        mutationFn: async (payload: {
            name: string;
            rack_id?: string | null;
        }) => {
            const url = DeviceApiRoutes.store.url();
            try {
                const resp = await axios.post(url, payload, {
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    withCredentials: true,
                });
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    if (e.response.status === 422) {
                        const err: any = new Error('Validation');
                        err.validation = e.response.data?.errors ?? {};
                        throw err;
                    }

                    throw new Error(
                        e.response.data?.message ?? 'Create failed',
                    );
                }

                throw new Error(e?.message ?? 'Create failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['devices'] });
            setCreateOpen(false);
            setCreateErrors({});
            toast.success('Device created');
        },
        onError: (err: any) => {
            if (err?.validation) setCreateErrors(err.validation);
            else toast.error(err?.message ?? 'Failed to create device');
        },
    });

    const updateMutation = useMutation({
        mutationFn: async ({
            id,
            name,
            rack_id,
        }: {
            id: string;
            name: string;
            rack_id?: string | null;
        }) => {
            const url = DeviceApiRoutes.update.url(id);
            try {
                const resp = await axios.put(
                    url,
                    { name, rack_id },
                    {
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                        },
                        withCredentials: true,
                    },
                );
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    throw new Error(
                        e.response.data?.message ?? 'Update failed',
                    );
                }

                throw new Error(e?.message ?? 'Update failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['devices'] });
            cancelEdit();
            toast.success('Device updated');
        },
        onError: (err: any) => {
            console.error('Update failed', err);
            toast.error(err?.message ?? 'Failed to update device');
        },
    });

    const submitEdit = () => {
        if (!editingId) return;
        updateMutation.mutate({
            id: editingId,
            name: editingName,
            rack_id: editingRackId ?? null,
        });
    };

    const deleteMutation = useMutation({
        mutationFn: async (id: string) => {
            const url = DeviceApiRoutes.destroy.url(id);
            try {
                const resp = await axios.delete(url, {
                    headers: { Accept: 'application/json' },
                    withCredentials: true,
                });
                if (resp.status === 204) return null;
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    throw new Error(
                        e.response.data?.message ?? 'Delete failed',
                    );
                }

                throw new Error(e?.message ?? 'Delete failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['devices'] });
            setDeleteOpen(false);
            setDeletingId(null);
            setDeletingName('');
            toast.success('Device deleted');
        },
        onError: (err: any) => {
            console.error('Delete failed', err);
            toast.error(err?.message ?? 'Failed to delete device');
        },
    });

    const startEdit = (device: any) => {
        setEditingId(device.id);
        setEditingName(device.name);
        setEditingRackId(device.rack_id ?? null);
        setEditOpen(true);
    };

    const cancelEdit = () => {
        setEditingId(null);
        setEditingName('');
        setEditingRackId(null);
        setEditOpen(false);
    };

    const destroy = (device: any) => {
        setDeletingId(device.id);
        setDeletingName(device.name);
        setDeleteOpen(true);
    };

    const confirmDelete = () => {
        if (!deletingId) return;
        deleteMutation.mutate(deletingId);
    };

    const onSearch = (e: React.FormEvent) => {
        e.preventDefault();
        setPage(1);
    };

    const loading = listQuery.isLoading || listQuery.isFetching;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Devices" />

            <div className="p-4">
                <div className="flex items-center gap-2">
                    <form onSubmit={onSearch} className="flex w-full gap-2">
                        <Input
                            placeholder="Search devices by name"
                            value={query}
                            onChange={(e) => setQuery(e.currentTarget.value)}
                        />
                        <Button type="submit">Search</Button>
                    </form>

                    <div>
                        <Button onClick={() => setCreateOpen(true)}>
                            Create
                        </Button>

                        <DeviceDialog
                            open={createOpen}
                            onOpenChange={(open) => {
                                setCreateOpen(open);
                                if (!open) setCreateErrors({});
                            }}
                            title="New Device"
                            description="Create a new device by name and rack."
                            initialName={''}
                            initialRack={null}
                            onSubmit={(payload) =>
                                createMutation.mutate(payload)
                            }
                            onCancel={() => setCreateErrors({})}
                            loading={createMutation.status === 'pending'}
                            errors={createErrors}
                            submitLabel="Create"
                            racks={racks}
                        />

                        <DeviceDialog
                            open={editOpen}
                            onOpenChange={(open) => {
                                setEditOpen(open);
                                if (!open) cancelEdit();
                            }}
                            title="Edit Device"
                            description="Update the device details."
                            initialName={editingName}
                            initialRack={editingRackId}
                            onSubmit={(payload) => {
                                if (!editingId) return;
                                updateMutation.mutate({
                                    id: editingId,
                                    name: payload.name,
                                    rack_id: payload.rack_id ?? null,
                                });
                            }}
                            onCancel={cancelEdit}
                            loading={updateMutation.status === 'pending'}
                            submitLabel="Save"
                            racks={racks}
                        />
                    </div>
                </div>

                <div className="mt-4">
                    {loading ? (
                        <div>Loading...</div>
                    ) : (
                        <ul className="space-y-2">
                            {items.map((d: Device) => (
                                <li
                                    key={d.id}
                                    className="rounded-md border p-3"
                                >
                                    <div className="flex items-center justify-between gap-4">
                                        <div className="flex-1">
                                            <div>
                                                <div className="text-sm font-medium">
                                                    {d.name}
                                                </div>
                                                <div className="text-xs text-muted-foreground">
                                                    {d.rack?.name ??
                                                        d.rack_id ??
                                                        '—'}
                                                </div>
                                            </div>
                                        </div>

                                        <div className="flex items-center gap-2">
                                            <div className="text-xs text-muted-foreground">
                                                {d.created_at}
                                            </div>
                                            <>
                                                <Button
                                                    size="sm"
                                                    variant="ghost"
                                                    onClick={() => startEdit(d)}
                                                >
                                                    Edit
                                                </Button>
                                                <Button
                                                    size="sm"
                                                    variant="destructive"
                                                    onClick={() => destroy(d)}
                                                >
                                                    Delete
                                                </Button>
                                            </>
                                        </div>
                                    </div>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>

                {meta && (
                    <div className="mt-4 flex items-center justify-between">
                        <div>
                            Page {meta.current_page} of {meta.last_page}
                        </div>
                        <div className="flex gap-2">
                            <Button
                                disabled={!meta.prev_page_url}
                                onClick={() => setPage(meta.current_page - 1)}
                            >
                                Prev
                            </Button>
                            <Button
                                disabled={!meta.next_page_url}
                                onClick={() => setPage(meta.current_page + 1)}
                            >
                                Next
                            </Button>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
