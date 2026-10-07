(() => {
  const root = document.documentElement;
  const savedTheme = localStorage.getItem('sportshub-theme');
  if (savedTheme) root.dataset.theme = savedTheme;

  document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
    const sync = () => btn.innerHTML = root.dataset.theme === 'light' ? '<i class="bi bi-moon-stars-fill"></i>' : '<i class="bi bi-sun-fill"></i>';
    sync();
    btn.addEventListener('click', () => {
      root.dataset.theme = root.dataset.theme === 'light' ? 'dark' : 'light';
      localStorage.setItem('sportshub-theme', root.dataset.theme);
      document.querySelectorAll('[data-theme-toggle]').forEach(b => b.innerHTML = root.dataset.theme === 'light' ? '<i class="bi bi-moon-stars-fill"></i>' : '<i class="bi bi-sun-fill"></i>');
    });
  });

  const sidebar = document.querySelector('[data-sidebar]');
  const overlay = document.querySelector('[data-sidebar-overlay]');
  document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => { sidebar?.classList.add('open'); overlay?.classList.add('show'); });
  overlay?.addEventListener('click', () => { sidebar?.classList.remove('open'); overlay.classList.remove('show'); });

  const observer = new IntersectionObserver(entries => entries.forEach(entry => {
    if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
  }), { threshold: .08 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  const countObserver = new IntersectionObserver(entries => entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el = entry.target, target = Number(el.dataset.count || 0), duration = 850, start = performance.now();
    const tick = now => { const p = Math.min(1, (now-start)/duration); el.textContent = Math.round(target*(1-Math.pow(1-p,3))).toLocaleString() + (target >= 500 ? '+' : ''); if (p < 1) requestAnimationFrame(tick); };
    requestAnimationFrame(tick); countObserver.unobserve(el);
  }), { threshold: .4 });
  document.querySelectorAll('[data-count]').forEach(el => countObserver.observe(el));

  document.querySelectorAll('.btn').forEach(btn => btn.addEventListener('click', e => {
    const r = document.createElement('span'); r.className='ripple'; const rect=btn.getBoundingClientRect(), size=Math.max(rect.width,rect.height); r.style.width=r.style.height=size+'px'; r.style.left=(e.clientX-rect.left-size/2)+'px'; r.style.top=(e.clientY-rect.top-size/2)+'px'; btn.appendChild(r); setTimeout(()=>r.remove(),600);
  }));

  document.querySelectorAll('[data-toast]').forEach(toast => {
    const close = () => { toast.style.opacity='0'; toast.style.transform='translateX(16px)'; setTimeout(()=>toast.remove(),250); };
    toast.querySelector('[data-toast-close]')?.addEventListener('click', close); setTimeout(close, 5000);
  });

  document.querySelectorAll('[data-confirm]').forEach(form => form.addEventListener('submit', e => {
    if (!confirm(form.dataset.confirm || 'Are you sure?')) e.preventDefault();
  }));

  document.querySelectorAll('[data-password-toggle]').forEach(btn => btn.addEventListener('click', () => {
    const input = btn.closest('.input-shell')?.querySelector('input'); if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.innerHTML = input.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
  }));

  const dialog = document.querySelector('[data-tournament-dialog]');
  document.querySelectorAll('[data-tournament-open]').forEach(btn => btn.addEventListener('click', () => {
    if (!dialog) return; dialog.querySelector('[data-tournament-id]').value = btn.dataset.id; dialog.querySelector('[data-tournament-name]').textContent = btn.dataset.name; dialog.showModal();
  }));
  document.querySelector('[data-tournament-close]')?.addEventListener('click', () => dialog?.close());
})();
