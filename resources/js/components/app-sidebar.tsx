import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { calendars, dashboard } from '@/routes';
import { calendar } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, CalendarDays, Folder, LayoutGrid, Bolt, Star, Lightbulb} from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Bokningar',
        href: dashboard(),
        icon: Lightbulb,
    },
            {
        title: 'Calednars',
        href: calendars(),
        icon: LayoutGrid,
    },
    {
        title: 'Kalendrar',
        href: calendar(),
        icon: CalendarDays,
    },

];

const footerNavItems: NavItem[] = [
    {
        title: 'App',
        href: 'https://ndsth.com/app',
        icon: Star,
    },
    {
        title: 'Admin',
        href: 'https://ndsth.com/admin',
        icon: Bolt,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
