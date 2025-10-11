import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { type Location } from '@/types';
import { useEffect, useState } from 'react';

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
    const [locationId, setLocationId] = useState<string | null>(
        initialLocation ?? null,
    );

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
                    {description && (
                        <DialogDescription>{description}</DialogDescription>
                    )}
                </DialogHeader>

                <div className="mt-4">
                    <Label
                        htmlFor="name"
                        className="mb-1 block text-sm font-medium"
                    >
                        Name
                    </Label>
                    <Input
                        id="name"
                        value={name}
                        onChange={(e) => setName(e.currentTarget.value)}
                    />
                    {errors?.name && (
                        <div className="mt-2 text-sm text-destructive">
                            {errors.name[0]}
                        </div>
                    )}
                </div>

                <div className="mt-4">
                    <Label
                        htmlFor="location"
                        className="mb-1 block text-sm font-medium"
                    >
                        Location
                    </Label>
                    <Select
                        id="location"
                        value={locationId ?? ''}
                        onValueChange={(val: string) =>
                            setLocationId(val === '__none' ? null : val || null)
                        }
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Select a location" />
                        </SelectTrigger>

                        <SelectContent>
                            {/* allow an explicit empty selection to make location optional; use a sentinel value (not empty string) */}
                            <SelectItem value="__none">No location</SelectItem>
                            {locations.map((loc) => (
                                <SelectItem key={loc.id} value={loc.id}>
                                    {loc.name}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant="outline" onClick={handleCancel}>
                            Cancel
                        </Button>
                    </DialogClose>
                    <Button
                        onClick={() =>
                            onSubmit({ name, location_id: locationId ?? null })
                        }
                        disabled={loading}
                    >
                        {submitLabel}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
