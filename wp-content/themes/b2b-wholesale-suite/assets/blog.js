document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('blog-grid');
  if (!grid) return;

  const cards = Array.from(grid.querySelectorAll('.post-card'));
  const tabs = document.querySelectorAll('.blog-tab');
  const sortSelect = document.getElementById('blog-sort-select');
  const emptyState = document.getElementById('blog-empty');

  function applyFilter(filter) {
    let visibleCount = 0;
    cards.forEach((card) => {
      const cats = (card.dataset.category || '').split(',').filter(Boolean);
      const show = filter === 'all' || cats.includes(filter);
      card.style.display = show ? '' : 'none';
      if (show) visibleCount++;
    });
    if (emptyState) emptyState.hidden = visibleCount !== 0;
  }

  function applySort(mode) {
    const sorted = cards.slice().sort((a, b) => {
      if (mode === 'title-asc') {
        return (a.dataset.title || '').localeCompare(b.dataset.title || '');
      }
      const da = new Date(a.dataset.date || 0).getTime();
      const db = new Date(b.dataset.date || 0).getTime();
      return mode === 'oldest' ? da - db : db - da;
    });
    sorted.forEach((card) => grid.appendChild(card));
  }

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      tabs.forEach((t) => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');
      applyFilter(tab.dataset.filter);
    });
  });

  if (sortSelect) {
    sortSelect.addEventListener('change', () => applySort(sortSelect.value));
  }
});
