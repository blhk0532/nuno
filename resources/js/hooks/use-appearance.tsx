import { useCallback, useEffect, useState } from 'react';
import { Appearance, applyTheme, setCookie, mediaQuery, handleSystemThemeChange } from '../utils/theme';

export function useAppearance() {
    const [appearance, setAppearance] = useState<Appearance>('system');

    const updateAppearance = useCallback((mode: Appearance) => {
        setAppearance(mode);

        // Store in localStorage for client-side persistence...
        localStorage.setItem('appearance', mode);

        // Store in cookie for SSR...
        setCookie('appearance', mode);

        applyTheme(mode);
    }, []);

    useEffect(() => {
        const savedAppearance = localStorage.getItem(
            'appearance',
        ) as Appearance | null;
        updateAppearance(savedAppearance || 'system');

        return () =>
            mediaQuery()?.removeEventListener(
                'change',
                handleSystemThemeChange,
            );
    }, [updateAppearance]);

    return { appearance, updateAppearance } as const;
}
