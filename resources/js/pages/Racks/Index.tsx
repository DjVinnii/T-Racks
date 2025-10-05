import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/components/ui/dialog';
import RackDialog from '@/components/racks/RackDialog';
import RackRoutes from '@/routes/racks';
import RackApiRoutes from '@/routes/api/racks';
import LocationApiRoutes from '@/routes/api/locations';
import { toast } from 'sonner';
import { useQuery, useMutation, useQueryClient, keepPreviousData } from '@tanstack/react-query';
import axios from 'axios';
import { type BreadcrumbItem, type Location, type Rack } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Racks', href: RackRoutes.index.url() },
];

export default function RacksIndex() {
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
    const [editingLocationId, setEditingLocationId] = useState<string | null>(null);
    const [createErrors, setCreateErrors] = useState<Record<string, string[]>>({});

    const queryClient = useQueryClient();

    const locationsQuery = useQuery<Location[]>({
        queryKey: ['locations', { per_page: 100 }],
        queryFn: async () => {
            const url = LocationApiRoutes.index.url({ query: { per_page: 100 } });
            const resp = await axios.get(url, { withCredentials: true });
            return resp.data.data ?? resp.data;
        },
    });

    const locations = locationsQuery.data ?? [];

    const listQuery = useQuery<{ items: Rack[]; meta: any }>({
        queryKey: ['racks', { page, perPage, query }],
        queryFn: async () => {
            const url = RackApiRoutes.index.url({ query: { page, per_page: perPage, name: query } });
            const resp = await axios.get(url, { headers: { Accept: 'application/json' }, withCredentials: true });
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
        mutationFn: async (payload: { name: string; location_id?: string | null }) => {
            const url = RackApiRoutes.store.url();
            try {
                const resp = await axios.post(url, payload, { headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, withCredentials: true });
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    if (e.response.status === 422) {
                        const err: any = new Error('Validation');
                        err.validation = e.response.data?.errors ?? {};
                        throw err;
                    }

                    throw new Error(e.response.data?.message ?? 'Create failed');
                }

                throw new Error(e?.message ?? 'Create failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['racks'] });
            setCreateOpen(false);
            setCreateErrors({});
            toast.success('Rack created');
        },
        onError: (err: any) => {
            if (err?.validation) setCreateErrors(err.validation);
            else toast.error(err?.message ?? 'Failed to create rack');
        },
    });

    const updateMutation = useMutation({
        mutationFn: async ({ id, name, location_id }: { id: string; name: string; location_id?: string | null }) => {
            const url = RackApiRoutes.update.url(id);
            try {
                const resp = await axios.put(url, { name, location_id }, { headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, withCredentials: true });
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    throw new Error(e.response.data?.message ?? 'Update failed');
                }

                throw new Error(e?.message ?? 'Update failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['racks'] });
            cancelEdit();
            toast.success('Rack updated');
        },
        onError: (err: any) => {
            console.error('Update failed', err);
            toast.error(err?.message ?? 'Failed to update rack');
        },
    });

    const submitEdit = () => {
        if (!editingId) return;
        updateMutation.mutate({ id: editingId, name: editingName, location_id: editingLocationId ?? null });
    };

    const deleteMutation = useMutation({
        mutationFn: async (id: string) => {
            const url = RackApiRoutes.destroy.url(id);
            try {
                const resp = await axios.delete(url, { headers: { Accept: 'application/json' }, withCredentials: true });
                if (resp.status === 204) return null;
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    throw new Error(e.response.data?.message ?? 'Delete failed');
                }

                throw new Error(e?.message ?? 'Delete failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['racks'] });
            setDeleteOpen(false);
            setDeletingId(null);
            setDeletingName('');
            toast.success('Rack deleted');
        },
        onError: (err: any) => {
            console.error('Delete failed', err);
            toast.error(err?.message ?? 'Failed to delete rack');
        },
    });

    const startEdit = (rack: any) => {
        setEditingId(rack.id);
        setEditingName(rack.name);
        setEditingLocationId(rack.location_id ?? null);
        setEditOpen(true);
    };

    const cancelEdit = () => {
        setEditingId(null);
        setEditingName('');
        setEditingLocationId(null);
        setEditOpen(false);
    };

    const destroy = (rack: any) => {
        setDeletingId(rack.id);
        setDeletingName(rack.name);
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
            <Head title="Racks" />

            <div className="p-4">
                <div className="flex items-center gap-2">
                    <form onSubmit={onSearch} className="flex w-full gap-2">
                        <Input placeholder="Search racks by name" value={query} onChange={(e) => setQuery(e.currentTarget.value)} />
                        <Button type="submit">Search</Button>
                    </form>

                    <div>
                        <Button onClick={() => setCreateOpen(true)}>Create</Button>

                        <RackDialog
                            open={createOpen}
                            onOpenChange={(open) => { setCreateOpen(open); if (!open) setCreateErrors({}); }}
                            title="New Rack"
                            description="Create a new rack by name and location."
                            initialName={''}
                            initialLocation={null}
                            onSubmit={(payload) => createMutation.mutate(payload)}
                            onCancel={() => setCreateErrors({})}
                            loading={createMutation.status === 'pending'}
                            errors={createErrors}
                            submitLabel="Create"
                            locations={locations}
                        />

                        <RackDialog
                            open={editOpen}
                            onOpenChange={(open) => { setEditOpen(open); if (!open) cancelEdit(); }}
                            title="Edit Rack"
                            description="Update the rack details."
                            initialName={editingName}
                            initialLocation={editingLocationId}
                            onSubmit={(payload) => {
                                if (!editingId) return;
                                updateMutation.mutate({ id: editingId, name: payload.name, location_id: payload.location_id ?? null });
                            }}
                            onCancel={cancelEdit}
                            loading={updateMutation.status === 'pending'}
                            submitLabel="Save"
                            locations={locations}
                        />

                        <Dialog open={deleteOpen} onOpenChange={(open) => { if (!open) { setDeletingId(null); setDeletingName(''); } setDeleteOpen(open); }}>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>Delete Rack</DialogTitle>
                                    <DialogDescription>Are you sure you want to delete this rack? This action cannot be undone.</DialogDescription>
                                </DialogHeader>

                                <div className="mt-4">
                                    <div className="text-sm">{deletingName}</div>
                                </div>

                                <DialogFooter>
                                    <DialogClose asChild>
                                        <Button variant="outline" onClick={() => { setDeleteOpen(false); setDeletingId(null); setDeletingName(''); }}>Cancel</Button>
                                    </DialogClose>
                                    <Button variant="destructive" onClick={() => confirmDelete()} disabled={deleteMutation.status === 'pending'}>Delete</Button>
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>
                    </div>
                </div>

                <div className="mt-4">
                    {loading ? (
                        <div>Loading...</div>
                    ) : (
                        <ul className="space-y-2">
                            {items.map((rack: Rack) => (
                                <li key={rack.id} className="rounded-md border p-3">
                                    <div className="flex items-center justify-between gap-4">
                                        <div className="flex-1">
                                            <div>
                                                <div className="text-sm font-medium">{rack.name}</div>
                                                <div className="text-xs text-muted-foreground">{rack.location?.name ?? rack.location_id ?? '—'}</div>
                                            </div>
                                        </div>

                                        <div className="flex items-center gap-2">
                                            <div className="text-xs text-muted-foreground">{rack.created_at}</div>
                                            <>
                                                <Button size="sm" variant="ghost" onClick={() => startEdit(rack)}>Edit</Button>
                                                <Button size="sm" variant="destructive" onClick={() => destroy(rack)}>Delete</Button>
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
                        <div>Page {meta.current_page} of {meta.last_page}</div>
                        <div className="flex gap-2">
                            <Button disabled={!meta.prev_page_url} onClick={() => setPage(meta.current_page - 1)}>Prev</Button>
                            <Button disabled={!meta.next_page_url} onClick={() => setPage(meta.current_page + 1)}>Next</Button>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
