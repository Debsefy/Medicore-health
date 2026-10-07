/* =========================================================
   MEDICORE HMS — Main JavaScript
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

  // ── SIDEBAR TOGGLE ─────────────────────────────────────
  const sidebar       = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const overlay       = document.getElementById('sidebarOverlay');

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => sidebar?.classList.toggle('open'));
  }
  overlay?.addEventListener('click', () => sidebar?.classList.remove('open'));

  // ── DARK MODE ──────────────────────────────────────────
  const darkToggle = document.getElementById('darkModeToggle');
  const savedTheme = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', savedTheme);
  if (darkToggle) {
    updateDarkIcon(savedTheme);
    darkToggle.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme');
      const next    = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
      updateDarkIcon(next);
    });
  }

  function updateDarkIcon(theme) {
    const icon = darkToggle?.querySelector('i');
    if (icon) icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
  }

  // ── TABS ───────────────────────────────────────────────
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const group = this.closest('.tabs').dataset.tabGroup || 'default';
      const target = this.dataset.tab;

      document.querySelectorAll(`.tab-btn[data-tab-group="${group}"], .tabs:not([data-tab-group]) .tab-btn`)
        .forEach(b => b.classList.remove('active'));
      document.querySelectorAll(`.tab-panel[data-tab-group="${group}"], .tab-panel:not([data-tab-group])`)
        .forEach(p => p.classList.remove('active'));

      this.classList.add('active');
      document.querySelector(`.tab-panel[data-tab="${target}"]`)?.classList.add('active');
    });
  });

  // Init first tab
  document.querySelectorAll('.tabs').forEach(tabs => {
    const first = tabs.querySelector('.tab-btn');
    if (first && !tabs.querySelector('.tab-btn.active')) first.click();
  });

  // ── MODALS ─────────────────────────────────────────────
  document.querySelectorAll('[data-modal]').forEach(trigger => {
    trigger.addEventListener('click', () => {
      const modal = document.getElementById(trigger.dataset.modal);
      modal?.classList.add('open');
    });
  });

  document.querySelectorAll('.modal-close, .modal-overlay').forEach(el => {
    el.addEventListener('click', function (e) {
      if (e.target === this || this.classList.contains('modal-close')) {
        this.closest('.modal-overlay')?.classList.remove('open');
      }
    });
  });

  // ── DROPDOWNS ──────────────────────────────────────────
  document.querySelectorAll('.dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', e => {
      e.stopPropagation();
      const dd = btn.closest('.dropdown');
      document.querySelectorAll('.dropdown.open').forEach(d => { if (d !== dd) d.classList.remove('open'); });
      dd.classList.toggle('open');
    });
  });

  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
  });

  // ── ALERTS AUTO-DISMISS ────────────────────────────────
  document.querySelectorAll('.alert[data-dismiss]').forEach(alert => {
    setTimeout(() => {
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-10px)';
      alert.style.transition = 'all .3s ease';
      setTimeout(() => alert.remove(), 300);
    }, 5000);
  });

  // ── CONFIRM DIALOGS ────────────────────────────────────
  document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const msg = this.dataset.confirm || 'Are you sure?';
      if (!confirm(msg)) e.preventDefault();
    });
  });

  // ── DYNAMIC INVOICE ITEMS ──────────────────────────────
  const addItemBtn  = document.getElementById('addInvoiceItem');
  const itemsTable  = document.getElementById('invoiceItemsBody');
  let itemCount = document.querySelectorAll('.invoice-item-row').length;

  addItemBtn?.addEventListener('click', () => {
    itemCount++;
    const row = document.createElement('tr');
    row.className = 'invoice-item-row';
    row.innerHTML = `
      <td><input type="text"    name="items[${itemCount}][desc]"  class="form-control form-control-sm" placeholder="Description" required></td>
      <td>
        <select name="items[${itemCount}][type]" class="form-select form-control-sm">
          <option value="consultation">Consultation</option>
          <option value="lab">Lab</option>
          <option value="pharmacy">Pharmacy</option>
          <option value="procedure">Procedure</option>
          <option value="other">Other</option>
        </select>
      </td>
      <td><input type="number"  name="items[${itemCount}][qty]"   class="form-control form-control-sm item-qty"   value="1" min="1"></td>
      <td><input type="number"  name="items[${itemCount}][price]" class="form-control form-control-sm item-price" value="0" step="0.01"></td>
      <td class="item-total">0.00</td>
      <td><button type="button" class="btn btn-danger btn-sm btn-icon remove-item"><i class="fas fa-times"></i></button></td>
    `;
    itemsTable?.appendChild(row);
    bindItemEvents(row);
    calcTotal();
  });

  function bindItemEvents(row) {
    row.querySelectorAll('.item-qty, .item-price').forEach(input => {
      input.addEventListener('input', calcTotal);
    });
    row.querySelector('.remove-item')?.addEventListener('click', function () {
      this.closest('tr').remove();
      calcTotal();
    });
  }

  document.querySelectorAll('.invoice-item-row').forEach(bindItemEvents);

  function calcTotal() {
    let subtotal = 0;
    document.querySelectorAll('.invoice-item-row').forEach(row => {
      const qty   = parseFloat(row.querySelector('.item-qty')?.value   || 0);
      const price = parseFloat(row.querySelector('.item-price')?.value || 0);
      const total = qty * price;
      const cell  = row.querySelector('.item-total');
      if (cell) cell.textContent = total.toFixed(2);
      subtotal += total;
    });

    const taxPct  = parseFloat(document.getElementById('taxPercent')?.value  || 0);
    const discount= parseFloat(document.getElementById('discountVal')?.value || 0);
    const tax     = subtotal * (taxPct / 100);
    const grand   = subtotal + tax - discount;

    const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val.toFixed(2); };
    setVal('subtotalDisplay', subtotal);
    setVal('taxDisplay',      tax);
    setVal('discountDisplay', discount);
    setVal('totalDisplay',    grand);
  }

  document.getElementById('taxPercent')?.addEventListener('input', calcTotal);
  document.getElementById('discountVal')?.addEventListener('input', calcTotal);

  // ── DYNAMIC PRESCRIPTION ROWS ──────────────────────────
  const addMedBtn = document.getElementById('addMedRow');
  let medCount = document.querySelectorAll('.med-row').length;

  addMedBtn?.addEventListener('click', () => {
    medCount++;
    const row = document.createElement('div');
    row.className = 'med-row form-row cols-4 mb-2';
    row.innerHTML = `
      <input type="text"   name="medications[${medCount}][name]"         class="form-control" placeholder="Drug name" required>
      <input type="text"   name="medications[${medCount}][dosage]"        class="form-control" placeholder="Dosage (e.g. 500mg)">
      <input type="text"   name="medications[${medCount}][frequency]"     class="form-control" placeholder="Frequency (e.g. 3x daily)">
      <div style="display:flex;gap:6px">
        <input type="text" name="medications[${medCount}][duration]"      class="form-control" placeholder="Duration (e.g. 7 days)">
        <button type="button" class="btn btn-danger btn-icon remove-med"><i class="fas fa-minus"></i></button>
      </div>
    `;
    document.getElementById('medRowsContainer')?.appendChild(row);
    row.querySelector('.remove-med')?.addEventListener('click', () => row.remove());
  });

  document.querySelectorAll('.remove-med').forEach(btn => {
    btn.addEventListener('click', function () { this.closest('.med-row').remove(); });
  });

  // ── PRINT ──────────────────────────────────────────────
  document.getElementById('printBtn')?.addEventListener('click', () => window.print());

  // ── NOTIFICATION BADGE ────────────────────────────────
  const badge = document.getElementById('notifBadge');
  if (badge && parseInt(badge.textContent) > 0) badge.classList.remove('hidden');

  // ── FILE INPUT PREVIEW ────────────────────────────────
  document.querySelectorAll('.file-input-preview').forEach(input => {
    input.addEventListener('change', function () {
      const preview = document.getElementById(this.dataset.preview);
      if (preview && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(this.files[0]);
      }
    });
  });

  // ── SEARCHABLE TABLE ──────────────────────────────────
  const liveSearch = document.getElementById('tableSearch');
  if (liveSearch) {
    liveSearch.addEventListener('input', function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll('.searchable-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    });
  }

  // ── SIDEBAR ACTIVE LINK ───────────────────────────────
  const path = window.location.pathname;
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href !== '/' && path.startsWith(href)) {
      link.classList.add('active');
    }
  });

  // ── DATE DEFAULT ──────────────────────────────────────
  document.querySelectorAll('input[type="date"].today-default').forEach(input => {
    if (!input.value) input.value = new Date().toISOString().split('T')[0];
  });

  // ── TOASTS ────────────────────────────────────────────
  window.showToast = function (msg, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} animate-fade-in`;
    toast.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:300px;max-width:400px;box-shadow:0 8px 24px rgba(0,0,0,.15)';
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 4000);
  };

  // ── CHART INIT (called from view scripts) ─────────────
  window.initCharts = function (appointmentData, revenueData, statusData, months) {
    // Monthly Appointments Chart
    const apptCanvas = document.getElementById('appointmentsChart');
    if (apptCanvas) {
      new Chart(apptCanvas, {
        type: 'bar',
        data: {
          labels: Object.values(months),
          datasets: [{
            label: 'Appointments',
            data: Object.values(months).map((_, i) => appointmentData[i + 1] || 0),
            backgroundColor: 'rgba(15, 111, 255, 0.12)',
            borderColor: '#0f6fff',
            borderWidth: 2,
            borderRadius: 6,
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,.05)' }, ticks: { font: { size: 12 } } },
            x: { grid: { display: false }, ticks: { font: { size: 12 } } }
          }
        }
      });
    }

    // Revenue Chart
    const revCanvas = document.getElementById('revenueChart');
    if (revCanvas) {
      new Chart(revCanvas, {
        type: 'line',
        data: {
          labels: Object.values(months),
          datasets: [{
            label: 'Revenue',
            data: Object.values(months).map((_, i) => parseFloat(revenueData[i + 1] || 0)),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,.08)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: '#10b981',
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,.05)' }, ticks: { callback: v => '₦' + v.toLocaleString() } },
            x: { grid: { display: false } }
          }
        }
      });
    }

    // Status Donut
    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
      const labels = Object.keys(statusData).map(k => k.charAt(0).toUpperCase() + k.slice(1));
      const values = Object.values(statusData);
      new Chart(statusCanvas, {
        type: 'doughnut',
        data: {
          labels,
          datasets: [{
            data: values,
            backgroundColor: ['#f59e0b','#2563eb','#10b981','#ef4444','#6b7280'],
            borderWidth: 0,
            hoverOffset: 6,
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, font: { size: 12 } } }
          }
        }
      });
    }
  };

});
