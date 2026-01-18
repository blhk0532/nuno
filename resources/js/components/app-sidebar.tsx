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
    SidebarTrigger,
} from '@/components/ui/sidebar';
import { app, bigCalendar, calendarMulti, calendars, dashboard, shadcnEventCalendar } from '@/routes';
import { calendar } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, CalendarDays, Folder, LayoutGrid, Bolt, Star, Lightbulb} from 'lucide-react';
import AppLogo from './app-logo';
import { DayViewMultiDayEventsRow } from '@/calendar/components/week-and-day-view/day-view-multi-day-events-row';
import { ToggleTheme } from '@/components/layout/change-theme';

const mainNavItems: NavItem[] = [
//   {
//       title: 'Boknings Kalenders NDS#1',
//       href: shadcnEventCalendar(),
//       icon: CalendarDays,
//   },
    {
        title: 'NDS Kalender #1',
        href: app(),
        icon: CalendarDays,
    },
    {
        title: 'NDS Kalender #2',
        href: dashboard(),
        icon: LayoutGrid,
    },
 //   {
 //       title: 'Boknings Kalenders NDS#4',
 //       href: bigCalendar(),
 //       icon: CalendarDays,
 //   },
 //           {
 //       title: 'NDS Kalender #3',
 //       href: calendars(),
 //       icon: CalendarDays,
 //   },

];

const footerNavItems: NavItem[] = [
//    {
//        title: 'NDS App',
//        href: 'https://ndsth.com/nds/app',
//        icon: LayoutGrid,
//    },
//    {
//        title: 'Admin',
//        href: 'https://ndsth.com/nds/admin',
//        icon: LayoutGrid,
//    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
 <SidebarTrigger className="sidebar-trigger z-100 ml-1" />

                        <SidebarMenuButton size="lg" asChild>


                                <AppLogo />

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
