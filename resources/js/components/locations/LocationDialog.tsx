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
import { useEffect, useState } from 'react';

type Props = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    title?: string;
    description?: string;
    initialName?: string;
    onSubmit: (name: string) => void;
    onCancel?: () => void;
    loading?: boolean;
    errors?: Record<string, string[]>;
    submitLabel?: string;
};

export default function LocationDialog({
    open,
    onOpenChange,
    title = 'Location',
    description,
    initialName = '',
    onSubmit,
    onCancel,
    loading = false,
    errors,
    submitLabel = 'Save',
}: Props) {
    const [name, setName] = useState(initialName);

    useEffect(() => {
        setName(initialName ?? '');
    }, [initialName, open]);

    const handleCancel = () => {
        onOpenChange(false);
        setName('');
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

                <div className="mt-4 grid items-center gap-3">
                    <Label htmlFor="name">Name</Label>
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

                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant="outline" onClick={handleCancel}>
                            Cancel
                        </Button>
                    </DialogClose>
                    <Button onClick={() => onSubmit(name)} disabled={loading}>
                        {submitLabel}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
