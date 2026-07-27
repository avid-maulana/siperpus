import './home';

document.addEventListener('DOMContentLoaded', () => {

    // ===========================
    // HERO BACKGROUND SLIDER
    // ===========================
    const slides = document.querySelectorAll('.hero-slide');

    if (slides.length) {
        let current = 0;

        const showSlide = (index) => {
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.classList.add('active');
            slide.style.zIndex = '2';
        } else {
            slide.classList.remove('active');
            slide.style.zIndex = '1';
        }
    });
};

        showSlide(current);

        setInterval(() => {
            current = (current + 1) % slides.length;
            showSlide(current);
        }, 7000); // ganti gambar setiap 7 detik
    }

    // ===========================
    // FILTER LITERATUR / SKRIPSI
    // ===========================
    const filterLiteratureBtn = document.getElementById('filterLiteratureBtn');
    const filterSkripsiBtn = document.getElementById('filterSkripsiBtn');
    const heroSearchForm = document.getElementById('heroSearchForm');
    const filterTarget = document.getElementById('filterTarget');

    if (!filterLiteratureBtn || !filterSkripsiBtn || !heroSearchForm || !filterTarget) {
        return;
    }

    const activeClasses = [
        'bg-white',
        'text-slate-950',
        'hover:bg-slate-100',
        'shadow-lg',
        'shadow-slate-950/15',
        'border',
        'border-transparent',
    ];

    const inactiveClasses = [
        'border',
        'border-white/30',
        'bg-white/10',
        'text-white',
        'hover:bg-white/15',
    ];

    const resetButton = (button) => {
        button.classList.remove(...activeClasses, ...inactiveClasses);

        button.classList.add(
            'inline-flex',
            'items-center',
            'justify-center',
            'rounded-full',
            'px-6',
            'py-3',
            'text-sm',
            'font-semibold',
            'transition'
        );
    };

    const applyMode = (mode) => {

        const route = mode === 'skripsi'
            ? filterSkripsiBtn.dataset.route
            : filterLiteratureBtn.dataset.route;

        filterTarget.value = mode;
        heroSearchForm.action = route || heroSearchForm.action;

        resetButton(filterLiteratureBtn);
        resetButton(filterSkripsiBtn);

        if (mode === 'skripsi') {

            filterSkripsiBtn.classList.add(...activeClasses);
            filterLiteratureBtn.classList.add(...inactiveClasses);

        } else {

            filterLiteratureBtn.classList.add(...activeClasses);
            filterSkripsiBtn.classList.add(...inactiveClasses);

        }
    };

    filterLiteratureBtn.addEventListener('click', () => applyMode('literature'));
    filterSkripsiBtn.addEventListener('click', () => applyMode('skripsi'));

    applyMode('literature');

});