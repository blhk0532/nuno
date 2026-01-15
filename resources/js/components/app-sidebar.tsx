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
import { app, bigCalendar, calendarMulti, calendars, dashboard, shadcnEventCalendar } from '@/routes';
import { calendar } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, CalendarDays, Folder, LayoutGrid, Bolt, Star, Lightbulb} from 'lucide-react';
import AppLogo from './app-logo';
import { DayViewMultiDayEventsRow } from '@/calendar/components/week-and-day-view/day-view-multi-day-events-row';

const mainNavItems: NavItem[] = [
//   {
//       title: 'Boknings Kalenders NDS#1',
//       href: shadcnEventCalendar(),
//       icon: CalendarDays,
//   },
    {
        title: 'Boknings Kalenders NDS#1',
        href: app(),
        icon: CalendarDays,
    },
    {
        title: 'Boknings Kalenders NDS#2',
        href: dashboard(),
        icon: CalendarDays,
    },
 //   {
 //       title: 'Boknings Kalenders NDS#4',
 //       href: bigCalendar(),
 //       icon: CalendarDays,
 //   },
            {
        title: 'Boknings Kalenders NDS#3',
        href: calendars(),
        icon: CalendarDays,
    },

];

const footerNavItems: NavItem[] = [
    {
        title: 'ND Application',
        href: 'https://ndsth.com/nds/app',
        icon: LayoutGrid,
    },
    {
        title: 'Administration',
        href: 'https://ndsth.com/nds/admin',
        icon: LayoutGrid,
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
