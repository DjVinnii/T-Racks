import React, { useEffect, useState } from 'react';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
    DialogClose,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Select, SelectTrigger, SelectContent, SelectItem, SelectValue } from '@/components/ui/select';
import { type Location } from '@/types';

type Props = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    title?: string;
    description?: string;
    initialName?: string;
    initialLocation?: string | null;
    onSubmit: (payload: { name: string; location_id?: string | null }) => void;
    onCancel?: () => void;
    loading?: boolean;
    errors?: Record<string, string[]>;
    submitLabel?: string;
    locations?: Location[];
};

export default function RackDialog({
    open,
    onOpenChange,
    title = 'Rack',
    description,
    initialName = '',
    initialLocation = null,
    onSubmit,
    onCancel,
    loading = false,
    errors,
    submitLabel = 'Save',
    locations = [],
}: Props) {
    const [name, setName] = useState(initialName);
    const [locationId, setLocationId] = useState<string | null>(initialLocation ?? null);

    useEffect(() => {
        setName(initialName ?? '');
        setLocationId(initialLocation ?? null);
    }, [initialName, initialLocation, open]);

    const handleCancel = () => {
        onOpenChange(false);
        setName('');
        setLocationId(null);
        if (onCancel) onCancel();
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>{title}</DialogTitle>
                    {description && <DialogDescription>{description}</DialogDescription>}
                </DialogHeader>

                <div className="mt-4">
                    <label className="block text-sm font-medium mb-1">Name</label>
                    <Input value={name} onChange={(e) => setName(e.currentTarget.value)} />
                    {errors?.name && <div className="text-sm text-destructive mt-2">{errors.name[0]}</div>}
                </div>

                <div className="mt-4">
                    <label className="block text-sm font-medium mb-1">Location</label>
                                    <Select value={locationId ?? ''} onValueChange={(val: string) => setLocationId(val === '__none' ? null : (val || null))}>
                        <SelectTrigger>
                            <SelectValue placeholder="Select a location" />
                        </SelectTrigger>

                        <SelectContent>
                            {/* allow an explicit empty selection to make location optional; use a sentinel value (not empty string) */}
                            <SelectItem value="__none">No location</SelectItem>
                            {locations.map((loc) => (
                                <SelectItem key={loc.id} value={loc.id}>{loc.name}</SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant="outline" onClick={handleCancel}>Cancel</Button>
                    </DialogClose>
                    <Button onClick={() => onSubmit({ name, location_id: locationId ?? null })} disabled={loading}>{submitLabel}</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
