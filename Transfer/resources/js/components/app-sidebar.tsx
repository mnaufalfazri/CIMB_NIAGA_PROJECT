import { Link, usePage } from '@inertiajs/react';
import { LayoutGrid, WalletCards, ArrowRightLeft, SendHorizontal, CreditCard } from 'lucide-react';
import AppLogo from '@/components/app-logo';
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
import type { NavItem } from '@/types';

export function AppSidebar() {
    const { auth, services } = usePage().props as any;
    const apiToken = auth?.api_token || '';
    const wealthUrl = services?.banking_url || 'http://localhost:8002';

    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: `${wealthUrl}/dashboard?token=${apiToken}`,
            icon: LayoutGrid,
            external: true,
        },
        {
            title: 'Wealth Dashboard',
            href: `${wealthUrl}/wealth/dashboard?token=${apiToken}`,
            icon: WalletCards,
            external: true,
        },
        {
            title: 'Mutasi Rekening',
            href: `${wealthUrl}/wealth/mutasi?token=${apiToken}`,
            icon: ArrowRightLeft,
            external: true,
        },
        {
            title: 'Transfer Uang',
            href: '/transfer',
            icon: SendHorizontal,
        },
        {
            title: 'Payment Tagihan',
            href: '/payment',
            icon: CreditCard,
        },
    ];

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <a href={`${wealthUrl}/dashboard?token=${apiToken}`}>
                                <AppLogo />
                            </a>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
