document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#productsTbody');
    const table = document.querySelector('.tabela-loja');
    const grid = tbody || document.querySelector('#productsGrid');

    if (!grid) return;

    const sortSelect = document.querySelector('#sortSelect');
    const paginationContainer = document.querySelector('#paginationControls');
    const perPage = Number((table && table.dataset.perPage) || grid.dataset.perPage) || 6;
    let currentPage = 1;

    const getItems = () => Array.from(grid.querySelectorAll('[data-product-card]'));

    const items = getItems();
    items.forEach((item, index) => {
        if (!item.dataset.originalIndex) {
            item.dataset.originalIndex = String(index);
        }
    });

    const parsePrice = (item) => {
        const val = parseFloat(String(item.dataset.price || '0').replace(',', '.'));
        return Number.isNaN(val) ? 0 : val;
    };

    const parseName = (item) => String(item.dataset.name || '').trim().toLowerCase();

    const sortItems = (list, mode) => {
        const sorted = [...list];

        switch (mode) {
            case 'price_asc':
                sorted.sort((a, b) => parsePrice(a) - parsePrice(b));
                break;
            case 'price_desc':
                sorted.sort((a, b) => parsePrice(b) - parsePrice(a));
                break;
            case 'name_asc':
                sorted.sort((a, b) => parseName(a).localeCompare(parseName(b), 'pt'));
                break;
            case 'name_desc':
                sorted.sort((a, b) => parseName(b).localeCompare(parseName(a), 'pt'));
                break;
            default:
                sorted.sort((a, b) => Number(a.dataset.originalIndex) - Number(b.dataset.originalIndex));
                break;
        }

        return sorted;
    };

    const makeButton = (label, page, active = false, disabled = false) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = label;
        btn.disabled = disabled;
        btn.className = 'button';
        btn.style.padding = '6px 12px';
        btn.style.fontSize = '0.9rem';
        btn.style.cursor = disabled ? 'not-allowed' : 'pointer';
        btn.style.opacity = disabled ? '0.45' : '1';
        if (active) {
            btn.style.background = '#0f766e';
            btn.style.color = '#ffffff';
        }

        if (!disabled) {
            btn.addEventListener('click', () => {
                currentPage = page;
                render();
            });
        }

        return btn;
    };

    const renderPagination = (totalItems) => {
        if (!paginationContainer) return;
        paginationContainer.innerHTML = '';

        if (totalItems === 0) return;

        const totalPages = Math.ceil(totalItems / perPage);

        const info = document.createElement('span');
        info.textContent = `Página ${currentPage} de ${totalPages} (${totalItems} artigos)`;
        info.style.fontSize = '0.9rem';
        info.style.fontWeight = 'bold';
        info.style.marginRight = '8px';
        paginationContainer.appendChild(info);

        if (totalPages <= 1) return;

        paginationContainer.appendChild(
            makeButton('Anterior', Math.max(1, currentPage - 1), false, currentPage === 1)
        );

        for (let page = 1; page <= totalPages; page++) {
            paginationContainer.appendChild(
                makeButton(String(page), page, page === currentPage, false)
            );
        }

        paginationContainer.appendChild(
            makeButton('Seguinte', Math.min(totalPages, currentPage + 1), false, currentPage === totalPages)
        );
    };

    const render = () => {
        const mode = sortSelect ? sortSelect.value : 'default';
        const ordered = sortItems(getItems(), mode);

        const totalItems = ordered.length;
        const totalPages = Math.max(1, Math.ceil(totalItems / perPage));
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * perPage;
        const end = start + perPage;

        ordered.forEach((item, idx) => {
            grid.appendChild(item);
            item.style.display = idx >= start && idx < end ? '' : 'none';
        });

        renderPagination(totalItems);
    };

    if (sortSelect) {
        sortSelect.addEventListener('change', () => {
            currentPage = 1;
            render();
        });
    }

    render();
});
