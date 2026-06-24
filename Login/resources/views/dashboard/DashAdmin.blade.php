<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - CIMB Niaga</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('dashboard/css/admin.css') }}">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="/DashAdmin" class="sidebar-logo">
        <img src="/images/cimb-logo.png" alt="CIMB Niaga" class="sidebar-logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="sidebar-logo-fallback" style="display:none;">
          <span class="logo-text">CIMB</span><span class="logo-text-accent">Niaga</span>
        </div>
      </a>
      <div class="sidebar-role-badge">Administrator</div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Manajemen</div>
      <a href="/DashAdmin" class="nav-item active" id="nav-users">
        <span class="nav-icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
        Nasabah
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="/logout" class="nav-item nav-item-logout" id="nav-logout">
        <span class="nav-icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </span>
        Keluar
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="layout-shell">

    <!-- Top Header -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="breadcrumb">
          <span class="breadcrumb-home">Admin</span>
          <span class="breadcrumb-sep">›</span>
          <span class="breadcrumb-current">Manajemen Nasabah</span>
        </div>
      </div>
      <div class="topbar-right">
        <div class="topbar-user">
          <div class="topbar-avatar" aria-label="Admin avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
          <div class="topbar-user-info">
            <span class="topbar-user-name">{{ auth()->user()->name }}</span>
            <span class="topbar-user-role">Administrator</span>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <main class="page-content">

      <!-- Flash Alerts -->
      @if(session('success'))
        <div class="alert alert-success" role="alert" id="alertSuccess">
          <span class="alert-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          <span>{{ session('success') }}</span>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
        </div>
      @endif
      @if(session('failed'))
        <div class="alert alert-error" role="alert" id="alertError">
          <span class="alert-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </span>
          <span>{{ session('failed') }}</span>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
        </div>
      @endif

      <!-- Hero Banner -->
      <div class="hero-banner">
        <div class="hero-deco hero-deco-1"></div>
        <div class="hero-deco hero-deco-2"></div>
        <div class="hero-content">
          <div>
            <h1 class="hero-title">Selamat datang, {{ auth()->user()->name }}!</h1>
            <p class="hero-subtitle">Kelola dan pantau seluruh nasabah CIMB Niaga dari panel administrasi ini.</p>
          </div>
          <div class="hero-badge">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Panel Admin Terverifikasi
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="stats-grid">
        <div class="stat-card" id="statTotal">
          <div class="stat-icon stat-icon-blue">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-label">Total Nasabah</span>
            <span class="stat-value">{{ \App\Models\User::where('role', 'nasabah')->count() }}</span>
          </div>
        </div>
        <div class="stat-card" id="statActive">
          <div class="stat-icon stat-icon-green">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-label">Nasabah Aktif</span>
            <span class="stat-value">{{ \App\Models\User::where('role', 'nasabah')->where('status', 'active')->count() }}</span>
          </div>
        </div>
        <div class="stat-card" id="statBanned">
          <div class="stat-icon stat-icon-red">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-label">Nasabah Dibanned</span>
            <span class="stat-value">{{ \App\Models\User::where('role', 'nasabah')->where('status', 'banned')->count() }}</span>
          </div>
        </div>
      </div>

      <!-- Users Table Card -->
      <div class="card" id="usersCard">
        <div class="card-header">
          <div class="card-title-group">
            <h2 class="card-title">Daftar Nasabah</h2>
            <p class="card-subtitle">Menampilkan {{ $users->total() }} nasabah terdaftar</p>
          </div>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="/DashAdmin" class="search-filter-bar" id="searchForm">
          <div class="search-wrapper">
            <span class="search-icon">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input
              type="text"
              name="search"
              id="searchInput"
              class="search-input"
              placeholder="Cari nama, email, atau nomor rekening..."
              value="{{ request('search') }}"
              autocomplete="off"
            >
            @if(request('search'))
              <button type="button" class="search-clear" id="clearSearch" onclick="document.getElementById('searchInput').value=''; document.getElementById('searchForm').submit();" aria-label="Hapus pencarian">&times;</button>
            @endif
          </div>

          <div class="filter-pills" role="group" aria-label="Filter status">
            <a href="/DashAdmin{{ request('search') ? '?search='.request('search') : '' }}"
               class="filter-pill {{ !request('status') ? 'active' : '' }}" id="filterAll">
              Semua
            </a>
            <a href="/DashAdmin?{{ request('search') ? 'search='.request('search').'&' : '' }}status=active"
               class="filter-pill filter-pill-green {{ request('status') === 'active' ? 'active' : '' }}" id="filterActive">
              <span class="pill-dot pill-dot-green"></span> Active
            </a>
            <a href="/DashAdmin?{{ request('search') ? 'search='.request('search').'&' : '' }}status=banned"
               class="filter-pill filter-pill-red {{ request('status') === 'banned' ? 'active' : '' }}" id="filterBanned">
              <span class="pill-dot pill-dot-red"></span> Banned
            </a>
          </div>

          <button type="submit" class="btn-search" id="searchBtn">Cari</button>
        </form>

        <!-- Table -->
        <div class="table-wrapper">
          <table class="data-table" id="nasabahTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nasabah</th>
                <th>Nomor Rekening</th>
                <th>Status</th>
                <th>Tanggal Registrasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $index => $user)
                <tr class="table-row" id="row-{{ $user->id }}">
                  <td class="td-num">{{ $users->firstItem() + $index }}</td>
                  <td class="td-user">
                    <div class="user-avatar" aria-hidden="true">
                      {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                      <span class="user-name">{{ $user->name }}</span>
                      <span class="user-email">{{ $user->email }}</span>
                    </div>
                  </td>
                  <td>
                    <span class="rekening-chip">{{ $user->nomor_rekening }}</span>
                  </td>
                  <td>
                    @if($user->status === 'active')
                      <span class="status-badge status-active">
                        <span class="status-dot status-dot-green"></span> Active
                      </span>
                    @elseif($user->status === 'banned')
                      <span class="status-badge status-banned">
                        <span class="status-dot status-dot-red"></span> Banned
                      </span>
                    @else
                      <span class="status-badge status-verify">
                        <span class="status-dot status-dot-yellow"></span> Verify
                      </span>
                    @endif
                  </td>
                  <td class="td-date">{{ $user->created_at->format('d M Y') }}<br><span class="td-time">{{ $user->created_at->format('H:i') }} WIB</span></td>
                  <td>
                    @if($user->status === 'banned')
                      <button type="button"
                        class="btn-action btn-unban"
                        id="btn-unban-{{ $user->id }}"
                        onclick="openModal('unban', {{ $user->id }}, '{{ addslashes($user->name) }}', '{{ route('admin.users.toggleBan', $user->id) }}')"
                      >
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Unban
                      </button>
                    @else
                      <button type="button"
                        class="btn-action btn-ban"
                        id="btn-ban-{{ $user->id }}"
                        onclick="openModal('ban', {{ $user->id }}, '{{ addslashes($user->name) }}', '{{ route('admin.users.toggleBan', $user->id) }}')"
                      >
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                        Ban
                      </button>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="empty-state" id="emptyState">
                    <div class="empty-icon">
                      <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="empty-title">Tidak ada nasabah ditemukan</p>
                    <p class="empty-sub">Coba ubah filter atau kata kunci pencarian Anda.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
          <div class="pagination-wrapper" id="paginationWrapper">
            {{ $users->links() }}
          </div>
        @endif
      </div>

    </main>
  </div>

  <!-- ===== CUSTOM MODAL ===== -->
  <div class="modal-overlay" id="modalOverlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1">
    <div class="modal" id="modal">
      <div class="modal-icon-wrap" id="modalIconWrap">
        <!-- Icon injected by JS -->
      </div>
      <h3 class="modal-title" id="modalTitle"></h3>
      <p class="modal-body" id="modalBody"></p>
      <div class="modal-actions">
        <button class="btn-modal-cancel" id="modalCancelBtn" onclick="closeModal()">Batal</button>
        <form id="modalForm" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn-modal-confirm" id="modalConfirmBtn"></button>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('dashboard/js/admin.js') }}"></script>
</body>
</html>