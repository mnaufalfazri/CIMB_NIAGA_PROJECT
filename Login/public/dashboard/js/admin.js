/* ============================================================
   ADMIN.JS — CIMB Niaga Admin Panel
   Handles: Custom Modal, Sidebar Toggle, Alert Auto-dismiss
   ============================================================ */

/* ---------- Custom Ban/Unban Modal ---------- */

const overlay   = document.getElementById('modalOverlay');
const modalForm = document.getElementById('modalForm');
const iconWrap  = document.getElementById('modalIconWrap');
const modalTitle   = document.getElementById('modalTitle');
const modalBody    = document.getElementById('modalBody');
const confirmBtn   = document.getElementById('modalConfirmBtn');

const ICONS = {
  ban: `<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
        </svg>`,
  unban: `<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
          </svg>`
};

/**
 * Opens the confirmation modal.
 * @param {'ban'|'unban'} type  - Action type
 * @param {number}        id    - User ID
 * @param {string}        name  - User display name
 * @param {string}        route - Form action URL
 */
function openModal(type, id, name, route) {
  const isBan = (type === 'ban');

  // Icon
  iconWrap.innerHTML = ICONS[type];
  iconWrap.className = 'modal-icon-wrap ' + (isBan ? 'modal-icon-ban' : 'modal-icon-unban');

  // Text
  modalTitle.textContent = isBan ? 'Ban Nasabah' : 'Unban Nasabah';
  modalBody.innerHTML = isBan
    ? `Apakah Anda yakin ingin mem-ban nasabah <strong>${escapeHtml(name)}</strong>?<br>Nasabah tidak akan dapat login hingga di-unban kembali.`
    : `Apakah Anda yakin ingin mengaktifkan kembali nasabah <strong>${escapeHtml(name)}</strong>?<br>Nasabah akan dapat login seperti biasa setelah ini.`;

  // Confirm button
  confirmBtn.textContent = isBan ? 'Ya, Ban Sekarang' : 'Ya, Unban Sekarang';
  confirmBtn.className = 'btn-modal-confirm ' + (isBan ? 'confirm-ban' : 'confirm-unban');

  // Form action
  modalForm.action = route;

  // Open with animation
  overlay.classList.add('open');
  overlay.focus();
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  overlay.classList.remove('open');
  document.body.style.overflow = '';
}

// Close on backdrop click
overlay.addEventListener('click', function (e) {
  if (e.target === overlay) closeModal();
});

// Close on Escape key
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape' && overlay.classList.contains('open')) {
    closeModal();
  }
});

/* ---------- HTML Escape Utility ---------- */
function escapeHtml(str) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(str));
  return div.innerHTML;
}

/* ---------- Alert Auto-dismiss ---------- */
(function () {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-8px)';
      setTimeout(function () { alert.remove(); }, 400);
    }, 4000);
  });
})();

/* ---------- Sidebar Toggle (Mobile) ---------- */
(function () {
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  if (!sidebarToggle || !sidebar) return;

  sidebarToggle.addEventListener('click', function () {
    sidebar.classList.toggle('open');
  });

  // Close sidebar on outside click (mobile)
  document.addEventListener('click', function (e) {
    if (window.innerWidth < 768 && sidebar.classList.contains('open')) {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove('open');
      }
    }
  });
})();
