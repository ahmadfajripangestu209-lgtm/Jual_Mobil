(() => {
  const cards = [...document.querySelectorAll('.car-card')];
  const search = document.querySelector('#car-search');
  const brand = document.querySelector('#brand-filter');
  const price = document.querySelector('#price-filter');
  const sort = document.querySelector('#sort-filter');
  const grid = document.querySelector('#car-grid');
  const empty = document.querySelector('#empty-state');
  const count = document.querySelector('#result-count');
  const toast = document.querySelector('#toast');
  let activeTag = '';

  const normalizeBrand = (value) => (value || '').trim().toLowerCase();

  const applyFilters = () => {
    const term = (search?.value || '').trim().toLowerCase();
    const maker = brand?.value || '';
    const maxPrice = Number(price?.value || 0);
    let visible = 0;

    cards.forEach((card) => {
      const matches = (!term || card.dataset.search.includes(term))
        && (!maker || normalizeBrand(card.dataset.brand) === normalizeBrand(maker))
        && (!maxPrice || Number(card.dataset.price) <= maxPrice)
        && (!activeTag || normalizeBrand(card.dataset.brand) === normalizeBrand(activeTag));
      card.hidden = !matches;
      if (matches) visible += 1;
    });

    if (sort?.value) {
      [...grid.querySelectorAll('.car-card:not([hidden])')]
        .sort((a, b) => sort.value === 'price-asc'
          ? Number(a.dataset.price) - Number(b.dataset.price)
          : Number(b.dataset.price) - Number(a.dataset.price))
        .forEach((card) => grid.insertBefore(card, empty));
    }

    if (count) count.textContent = `${visible} mobil tersedia`;
    if (empty) empty.style.display = visible ? 'none' : 'block';
  };

  search?.addEventListener('input', applyFilters);
  price?.addEventListener('change', applyFilters);
  sort?.addEventListener('change', applyFilters);
  brand?.addEventListener('change', () => {
    activeTag = '';
    document.querySelectorAll('.tag[data-brand]').forEach((tag) => tag.classList.remove('selected'));
    applyFilters();
  });

  document.querySelectorAll('.tag[data-brand]').forEach((tag) => {
    tag.addEventListener('click', () => {
      activeTag = activeTag === tag.dataset.brand ? '' : tag.dataset.brand;
      brand.value = activeTag;
      document.querySelectorAll('.tag[data-brand]').forEach((item) => item.classList.toggle('selected', item === tag && activeTag !== ''));
      applyFilters();
    });
  });

  document.querySelector('#filter-submit')?.addEventListener('click', () => {
    applyFilters();
    document.querySelector('#katalog')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  document.querySelectorAll('.heart-btn').forEach((button) => {
    button.addEventListener('click', () => {
      button.classList.toggle('saved');
      button.setAttribute('aria-pressed', button.classList.contains('saved') ? 'true' : 'false');
      showToast(button.classList.contains('saved') ? 'Mobil ditambahkan ke favorit.' : 'Mobil dihapus dari favorit.');
    });
  });

  document.querySelector('#menu-toggle')?.addEventListener('click', () => {
    const menu = document.querySelector('#nav-links');
    const open = menu.classList.toggle('open');
    document.querySelector('#menu-toggle').setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  function showToast(message) {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    window.setTimeout(() => toast.classList.remove('show'), 2200);
  }
})();
