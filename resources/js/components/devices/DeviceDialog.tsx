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
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { type Rack } from '@/types';
import { SelectContent } from '@radix-ui/react-select';
import { useEffect, useState } from 'react';

type Props = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    title?: string;
    description?: string;
    initialName?: string;
    initialRack?: string | null;
    onSubmit: (payload: { name: string; rack_id?: string | null }) => void;
    onCancel?: () => void;
    loading?: boolean;
    errors?: Record<string, string[]>;
    submitLabel?: string;
    racks?: Rack[];
};

export default function DeviceDialog({
    open,
    onOpenChange,
    title = 'Device',
    description,
    initialName = '',
    initialRack = null,
    onSubmit,
    onCancel,
    loading = false,
    errors,
    submitLabel = 'Save',
    racks = [],
}: Props) {
    const [name, setName] = useState(initialName);
    const [rackId, setRackId] = useState<string | null>(initialRack ?? null);

    useEffect(() => {
        setName(initialName ?? '');
        setRackId(initialRack ?? null);
    }, [initialName, initialRack, open]);

    const handleCancel = () => {
        onOpenChange(false);
        setName('');
        setRackId(null);
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
                        htmlFor="rack"
                        className="mb-1 block text-sm font-medium"
                    >
                        Rack
                    </Label>
                    <Select
                        id="rack"
                        value={rackId ?? ''}
                        onValueChange={(val: string) =>
                            setRackId(val === '__none' ? null : val || null)
                        }
                        className="w-full rounded border px-3 py-2"
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Select a rack" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="__none">No rack</SelectItem>
                            {racks.map((r) => (
                                <SelectItem key={r.id} value={r.id}>
                                    {r.name}
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
                            onSubmit({ name, rack_id: rackId ?? null })
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
