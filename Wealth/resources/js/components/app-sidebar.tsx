import { Link, usePage } from '@inertiajs/react';
import { BookOpen, FolderGit2, LayoutGrid, WalletCards, ArrowRightLeft, SendHorizontal, CreditCard } from 'lucide-react';
import AppLogo from '@/components/app-logo';
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
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

export function AppSidebar() {
    const { auth, services } = usePage().props as any;
    const apiToken = auth?.api_token || '';
    const paymentUrl = services?.payment_url || 'http://localhost:8003';

    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: dashboard(),
            icon: LayoutGrid,
        },
        {
            title: 'Wealth Dashboard',
            href: '/wealth/dashboard',
            icon: WalletCards,
        },
        {
            title: 'Mutasi Rekening',
            href: '/wealth/mutasi',
            icon: ArrowRightLeft,
        },
        {
            title: 'Transfer Uang',
            href: `${paymentUrl}/transfer?token=${apiToken}`,
            icon: SendHorizontal,
            external: true,
        },
        {
            title: 'Payment Tagihan',
            href: `${paymentUrl}/payment?token=${apiToken}`,
            icon: CreditCard,
            external: true,
        },
    ];

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
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
