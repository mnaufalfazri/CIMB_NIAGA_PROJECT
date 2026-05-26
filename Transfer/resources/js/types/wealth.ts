export interface Account {
    id: number;
    user_id: number;
    user_name: string | null;
    nomor_rekening: string;
    account_type: 'saving' | 'business' | 'deposit';
    currency: string;
    balance: number;
    status: 'active' | 'frozen' | 'closed';
    version: number;
    created_at: string;
    updated_at: string;
    account_type_label?: string;
    status_label?: string;
}

export interface Transaction {
    id: number;
    account_id: number;
    reference_id: string;
    direction: 'credit' | 'debit';
    transaction_type:
        | 'transfer'
        | 'payment'
        | 'topup'
        | 'withdraw'
        | 'deposit'
        | 'admin_fee'
        | 'initial'
        | 'refund'
        | 'reversal';
    amount: number;
    balance_before: number;
    balance_after: number;
    status: 'pending' | 'success' | 'failed' | 'reversed';
    description: string | null;
    counterparty_account: string | null;
    counterparty_name: string | null;
    created_at: string;
    transaction_type_label?: string;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginatedTransactions {
    data: Transaction[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLink[];
}

export interface DashboardProps {
    account: Account | null;
    totalBalance: number;
    incomeThisMonth: number;
    expenseThisMonth: number;
    recentTransactions: Transaction[];
}

export interface MutasiProps {
    account: Account | null;
    transactions: PaginatedTransactions | null;
    filters: {
        date_from?: string;
        date_to?: string;
        transaction_type?: string;
        direction?: string;
    };
}

export const TRANSACTION_TYPE_LABELS: Record<string, string> = {
    all: 'Semua Tipe',
    transfer: 'Transfer',
    payment: 'Pembayaran',
    topup: 'Top Up',
    withdraw: 'Penarikan',
    deposit: 'Setoran',
    admin_fee: 'Biaya Admin',
    initial: 'Saldo Awal',
    refund: 'Refund',
    reversal: 'Reversal',
};

export const DIRECTION_LABELS: Record<string, string> = {
    all: 'Semua',
    credit: 'Masuk (Credit)',
    debit: 'Keluar (Debit)',
};
