import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
    DialogClose,
} from '@/components/ui/dialog';
import LocationDialog from '@/components/locations/LocationDialog';
import LocationRoutes from '@/routes/locations';
import LocationApiRoutes from '@/routes/api/locations';
import { toast } from 'sonner';
import { useQuery, useMutation, useQueryClient, keepPreviousData } from '@tanstack/react-query';
import axios from 'axios';
import { type BreadcrumbItem, type Location } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Locations', href: LocationRoutes.index.url() },
];


export default function LocationsIndex() {
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
    const [createName, setCreateName] = useState('');
    const [createErrors, setCreateErrors] = useState<Record<string, string[]>>({});

    const queryClient = useQueryClient();

    // List query
    const listQuery = useQuery<{ items: Location[]; meta: any }>({
        queryKey: ['locations', { page, perPage, query }],
        queryFn: async () => {
            const url = LocationApiRoutes.index.url({ query: { page, per_page: perPage, name: query } });
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

    // create
    const createMutation = useMutation({
        mutationFn: async (name: string) => {
            const url = LocationApiRoutes.store.url();
            try {
                const resp = await axios.post(url, { name }, { headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, withCredentials: true });
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
            queryClient.invalidateQueries({ queryKey: ['locations'] });
            setCreateName('');
            setCreateOpen(false);
            setCreateErrors({});
            toast.success('Location created');
        },
        onError: (err: any) => {
            if (err?.validation) setCreateErrors(err.validation);
            else toast.error(err?.message ?? 'Failed to create location');
        },
    });

    // update
    const updateMutation = useMutation({
        mutationFn: async ({ id, name }: { id: string; name: string }) => {
            const url = LocationApiRoutes.update.url(id);
            try {
                const resp = await axios.put(url, { name }, { headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, withCredentials: true });
                return resp.data;
            } catch (e: any) {
                if (axios.isAxiosError(e) && e.response) {
                    throw new Error(e.response.data?.message ?? 'Update failed');
                }

                throw new Error(e?.message ?? 'Update failed');
            }
        },
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['locations'] });
            cancelEdit();
            toast.success('Location updated');
        },
        onError: (err: any) => {
            console.error('Update failed', err);
            toast.error(err?.message ?? 'Failed to update location');
        },
    });

    const submitEdit = () => {
        if (!editingId) return;
        updateMutation.mutate({ id: editingId, name: editingName });
    };

    // delete
    const deleteMutation = useMutation({
        mutationFn: async (id: string) => {
            const url = LocationApiRoutes.destroy.url(id);
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
            queryClient.invalidateQueries({ queryKey: ['locations'] });
            setDeleteOpen(false);
            setDeletingId(null);
            setDeletingName('');
            toast.success('Location deleted');
        },
        onError: (err: any) => {
            console.error('Delete failed', err);
            toast.error(err?.message ?? 'Failed to delete location');
        },
    });

    const startEdit = (loc: Location) => {
        setEditingId(loc.id);
        setEditingName(loc.name);
        setEditOpen(true);
    };

    const cancelEdit = () => {
        setEditingId(null);
        setEditingName('');
        setEditOpen(false);
    };

    const destroy = (loc: Location) => {
        setDeletingId(loc.id);
        setDeletingName(loc.name);
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
            <Head title="Locations" />

            <div className="p-4">
                <div className="flex items-center gap-2">
                    <form onSubmit={onSearch} className="flex w-full gap-2">
                        <Input placeholder="Search locations by name" value={query} onChange={(e) => setQuery(e.currentTarget.value)} />
                        <Button type="submit">Search</Button>
                    </form>

                    {/* New Location modal trigger */}
                    <div>
                        <Button onClick={() => setCreateOpen(true)}>Create</Button>

                        <LocationDialog
                            open={createOpen}
                            onOpenChange={(open) => { setCreateOpen(open); if (!open) setCreateName(''); }}
                            title="New Location"
                            description="Create a new location by name."
                            initialName={createName}
                            onSubmit={(name) => createMutation.mutate(name)}
                            onCancel={() => { setCreateName(''); setCreateErrors({}); }}
                            loading={createMutation.status === 'pending'}
                            errors={createErrors}
                            submitLabel="Create"
                        />

                        <LocationDialog
                            open={editOpen}
                            onOpenChange={(open) => { setEditOpen(open); if (!open) cancelEdit(); }}
                            title="Edit Location"
                            description="Update the name of the location."
                            initialName={editingName}
                            onSubmit={(name) => submitEdit()}
                            onCancel={cancelEdit}
                            loading={updateMutation.status === 'pending'}
                            submitLabel="Save"
                        />

                        {/* Delete confirmation modal (kept inline since it differs slightly) */}
                        
                        <Dialog open={deleteOpen} onOpenChange={(open) => { if (!open) { setDeletingId(null); setDeletingName(''); } setDeleteOpen(open); }}>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>Delete Location</DialogTitle>
                                    <DialogDescription>Are you sure you want to delete this location? This action cannot be undone.</DialogDescription>
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
                            {items.map((loc) => (
                                <li key={loc.id} className="rounded-md border p-3">
                                    <div className="flex items-center justify-between gap-4">
                                        <div className="flex-1">
                                            {editingId === loc.id ? (
                                                <div className="flex gap-2">
                                                    <Input value={editingName} onChange={(e) => setEditingName(e.currentTarget.value)} />
                                                    <Button onClick={() => submitEdit()}>Save</Button>
                                                    <Button variant="outline" onClick={cancelEdit}>Cancel</Button>
                                                </div>
                                            ) : (
                                                <div>
                                                    <div className="text-sm font-medium">{loc.name}</div>
                                                    <div className="text-xs text-muted-foreground">{loc.id}</div>
                                                </div>
                                            )}
                                        </div>

                                        <div className="flex items-center gap-2">
                                            <div className="text-xs text-muted-foreground">{loc.created_at}</div>
                                            {editingId !== loc.id && (
                                                <>
                                                    <Button size="sm" variant="ghost" onClick={() => startEdit(loc)}>Edit</Button>
                                                    <Button size="sm" variant="destructive" onClick={() => destroy(loc)}>Delete</Button>
                                                </>
                                            )}
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
